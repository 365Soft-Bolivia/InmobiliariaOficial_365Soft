# ================================================================
# Stage 1: Node 22 - Build frontend assets (Vite + Vue 3 + TS)
# ================================================================
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci --frozen-lockfile

COPY . .

# DOCKER_BUILD=1 le indica a vite.config.ts que omita wayfinder:generate
# (requiere PHP que no existe en esta etapa)
ENV DOCKER_BUILD=1
RUN npm run build

# ================================================================
# Stage 2: PHP 8.3-FPM - Application de producción
# ================================================================
FROM php:8.3-fpm-alpine AS production

# Dependencias del sistema
RUN apk add --no-cache \
    autoconf \
    bash \
    curl \
    freetype-dev \
    g++ \
    gettext-dev \
    git \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    libzip-dev \
    make \
    mysql-client \
    oniguruma-dev \
    shadow \
    supervisor \
    tzdata \
    unzip \
    zip

# Configurar y compilar extensiones PHP
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pdo \
    pdo_mysql \
    pcntl \
    xml \
    zip

# Extensión Redis (phpredis)
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer 2
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer files primero (cache de capas)
COPY composer.json composer.lock ./

# Instalar dependencias PHP de producción
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist

# Copiar el código fuente
COPY . .

# Copiar assets compilados del stage node-builder
COPY --from=node-builder /app/public/build ./public/build

# Configuración PHP de producción
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Configuración Supervisor
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Script de entrada
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# ================================================================
# Stage 3: Nginx - Web server con assets estáticos embebidos
# ================================================================
FROM nginx:1.27-alpine AS nginx

# Copiar assets estáticos desde el stage de producción
COPY --from=production /var/www/html/public /var/www/html/public

# Configuración Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Eliminar config por defecto
RUN rm -f /etc/nginx/conf.d/default.conf.default

EXPOSE 80 443
