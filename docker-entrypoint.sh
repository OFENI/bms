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

# Start Apache
exec apache2-foreground

