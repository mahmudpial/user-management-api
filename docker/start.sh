#!/bin/bash

php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache

php-fpm -D
sleep 2

nginx -g "daemon off;"