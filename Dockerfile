FROM php:8.2-fpm

# ১. প্রয়োজনীয় সিস্টেম প্যাকেজগুলো ইন্সটল
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# ২. GD কনফিগার করা
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# ৩. এক্সটেনশনগুলো ইন্সটল করা (pdo_pgsql-এর জন্য libpq-dev প্রয়োজন যা উপরে ইন্সটল হয়েছে)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৪. Composer ইন্সটল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# ৫. পারমিশন ঠিক করা
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT