#!/bin/bash

# Run Laravel setup
php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache

# Start PHP-FPM in background
php-fpm -D

# Wait for PHP-FPM to be ready
sleep 2

# Test nginx config
nginx -t

# Start Nginx in foreground
nginx -g "daemon off;"