#!/bin/bash
set -e

# Wait for MySQL to be ready (replace 'db' with your database service name if different)
until nc -z -v -w30 $DB_HOST $DB_PORT; do
  echo "Waiting for database connection..."
  sleep 5
done

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key if .env exists
if [ -f .env ]; then
  php artisan key:generate
fi

# Run database migrations
php artisan migrate --force
chown -R www-data:www-data /var/www/Abajim/storage
chmod -R 775 /var/www/Abajim/storage
# Execute the CMD from Dockerfile
exec "$@"