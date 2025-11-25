#!/bin/bash
set -e

# Substitute PORT in Apache config
envsubst '${PORT}' < /etc/apache2/sites-available/000-default.conf > /tmp/apache-config.conf
mv /tmp/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Update Apache to listen on PORT
echo "Listen ${PORT:-80}" > /etc/apache2/ports.conf

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

