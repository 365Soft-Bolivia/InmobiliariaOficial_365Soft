#!/bin/sh
set -e

# ================================================================
# docker-entrypoint.sh — Inicialización del contenedor Laravel
# ================================================================

echo "▶  Iniciando InmobiliariaOficial 365Soft..."

# ── Esperar MySQL ─────────────────────────────────────────────
echo "⏳ Esperando conexión a la base de datos..."
MAX_RETRIES=30
RETRY=0

until php -r "
    try {
        \$dsn = 'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE');
        new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        exit(0);
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null; do
    RETRY=$((RETRY + 1))
    if [ "$RETRY" -ge "$MAX_RETRIES" ]; then
        echo "✗  No se pudo conectar a la base de datos después de $MAX_RETRIES intentos."
        exit 1
    fi
    echo "   Reintentando ($RETRY/$MAX_RETRIES)..."
    sleep 3
done

echo "✓  Base de datos disponible."

# ── Generar APP_KEY si no existe ──────────────────────────────
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:CHANGE_ME" ]; then
    echo "⚙  Generando APP_KEY..."
    php artisan key:generate --ansi --force
fi

# ── Migraciones ───────────────────────────────────────────────
echo "⚙  Ejecutando migraciones..."
php artisan migrate --force

# ── Storage symlink ───────────────────────────────────────────
if [ ! -L /var/www/html/public/storage ]; then
    echo "⚙  Creando symlink de storage..."
    php artisan storage:link
fi

# ── Caché de configuración, rutas y vistas ────────────────────
echo "⚙  Cacheando configuración y rutas..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# ── Permisos finales ──────────────────────────────────────────
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "✓  Aplicación lista. Iniciando servicios..."
echo ""

exec "$@"
