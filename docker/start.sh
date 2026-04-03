#!/bin/bash

php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache

# Replace PORT in nginx config dynamically
sed -i "s/listen 80;/listen ${PORT:-80};/" /etc/nginx/sites-available/default

# Start PHP-FPM in background
php-fpm -D

# Wait for PHP-FPM to be ready
sleep 3

# Start Nginx in foreground
exec nginx -g "daemon off;"