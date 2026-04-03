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

# Write nginx config directly with correct port
cat > /etc/nginx/sites-available/default << EOF
server {
    listen $NGINX_PORT;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;

    client_max_body_size 100M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

echo "=== Testing nginx config ==="
nginx -t

echo "=== Starting PHP-FPM ==="
php-fpm -D

echo "=== Waiting for PHP-FPM ==="
sleep 3

echo "=== Starting Nginx ==="
exec nginx -g "daemon off;"