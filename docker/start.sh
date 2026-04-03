#!/bin/bash
set -e

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Caching config ==="
php artisan config:clear
php artisan config:cache
php artisan route:cache

echo "=== Setting PORT ==="
NGINX_PORT=${PORT:-80}
echo "Using port: $NGINX_PORT"
sed -i "s/listen 80;/listen $NGINX_PORT;/" /etc/nginx/sites-available/default

echo "=== Testing nginx config ==="
nginx -t

echo "=== Starting PHP-FPM ==="
php-fpm -D

echo "=== Waiting for PHP-FPM ==="
sleep 3

echo "=== Starting Nginx ==="
exec nginx -g "daemon off;"