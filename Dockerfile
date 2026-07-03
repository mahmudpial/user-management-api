FROM php:8.2-fpm

# ১. প্রয়োজনীয় সিস্টেম প্যাকেজগুলো ইন্সটল করা
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

# ২. GD এক্সটেনশন কনফিগার করা
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# ৩. এক্সটেনশনগুলো আলাদাভাবে ইন্সটল করা (এতে এরর হলে ধরা সহজ হয়)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৪. Composer ইন্সটল করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT