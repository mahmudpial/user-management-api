# PHP এবং Nginx যুক্ত ইমেজ ব্যবহার করা
FROM php:8.2-fpm

# প্রয়োজনীয় সিস্টেম প্যাকেজ ইন্সটল করা
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql gd

# Composer ইন্সটল করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ওয়ার্কিং ডিরেক্টরি
WORKDIR /var/www

# প্রজেক্ট ফাইল কপি করা
COPY . .

# পারমিশন সেট করা
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# কমান্ড রান করা
CMD php artisan serve --host=0.0.0.0 --port=$PORT