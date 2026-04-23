#!/bin/bash
set -e

echo "============================================"
echo "  TESSMS - Starting Application"
echo "============================================"

# Ensure storage directories exist and are writable
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views
mkdir -p storage/logs storage/app/public
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Create storage symlink if it doesn't exist
if [ ! -L "public/storage" ]; then
    echo "Creating storage symlink..."
    php artisan storage:link
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Cache Laravel configuration (only if APP_KEY is set)
if [ -n "$APP_KEY" ]; then
    echo "Caching Laravel configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Run database migrations (if DB is configured)
if [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Warning: Migrations failed. Database may not be ready yet."
fi

# Clear and optimize
php artisan optimize

echo "============================================"
echo "  Starting Apache..."
echo "============================================"

# Start Apache in foreground
exec apache2-foreground
