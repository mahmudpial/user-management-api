#!/bin/bash
set -e

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Caching ==="
php artisan config:cache
php artisan route:cache

echo "=== Setting PORT ==="
NGINX_PORT=${PORT:-8080}
echo "Using port: $NGINX_PORT"
sed -i "s/NGINX_PORT/$NGINX_PORT/" /etc/nginx/sites-available/default

echo "=== Starting supervisor ==="
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf