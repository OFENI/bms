#!/bin/bash
set -e

# Wait for database to be ready (if needed)
# You can add database connection check here if needed

# Generate application key if not set
php artisan key:generate --force || true

# Run migrations
php artisan migrate --force || true

# Cache configuration
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start PHP built-in server (works better with Render's PORT variable)
# Render provides PORT environment variable
exec php -S 0.0.0.0:${PORT:-80} -t public

