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

# ── Validar APP_KEY ───────────────────────────────────────────
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:CHANGE_ME" ]; then
    echo "✗  APP_KEY no está configurado en el .env. Deteniendo."
    echo "   Genera uno con: php artisan key:generate --show"
    echo "   Y agrégalo al .env: APP_KEY=base64:..."
    exit 1
fi

# ── Migraciones ───────────────────────────────────────────────
echo "⚙  Ejecutando migraciones..."
php artisan migrate --force

# ── Seeders (solo primera vez, si la BD está vacía) ───────────
# Evita re-sembrar en cada reinicio y duplicar datos en producción.
# Si la tabla users ya tiene registros, se omite el seed.
# Usa PDO directo porque tinker no está disponible en --no-dev.
USERS_COUNT=$(php -r "
    try {
        \$pdo = new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        // Verificar si la tabla users existe antes de contar
        \$stmt = \$pdo->query(\"SHOW TABLES LIKE 'users'\");
        if (\$stmt->rowCount() === 0) {
            echo '0';
        } else {
            echo (string) \$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        }
    } catch (Exception \$e) {
        echo '0';
    }
" 2>/dev/null || echo "0")

if [ "$USERS_COUNT" = "0" ]; then
    echo "⚙  Base de datos vacía. Ejecutando seeders..."
    php artisan db:seed --force
    echo "✓  Seeders completados."
else
    echo "ℹ  Base de datos ya tiene datos ($USERS_COUNT usuarios). Seed omitido."
fi

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
