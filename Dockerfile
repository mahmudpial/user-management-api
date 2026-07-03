FROM php:8.2-fpm

# ১. প্যাকেজ লিস্ট আপডেট এবং প্রয়োজনীয় লাইব্রেরি ইন্সটল
# এখানে libpq-dev এবং postgresql-client নিশ্চিতভাবে রাখা হয়েছে
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

# ২. GD এবং অন্যান্য এক্সটেনশন ইন্সটল
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৩. Composer ইন্সটল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT