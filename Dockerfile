FROM php:8.2-fpm

# ১. সিস্টেম প্যাকেজ ইন্সটল
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    postgresql-client \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# ২. GD কনফিগারেশন
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# ৩. এক্সটেনশন ইন্সটল (এখানেই ডকার ক্যাশ আটকে থাকে, তাই 'libpq-dev' যাতে অবশ্যই পায় তা নিশ্চিত করছি)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৪. Composer ইন্সটল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT