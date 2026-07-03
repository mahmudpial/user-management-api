# PHP 8.2 FPM ইমেজ ব্যবহার করছি
FROM php:8.2-fpm

# ১. সিস্টেম প্যাকেজ এবং প্রয়োজনীয় লাইব্রেরি ইন্সটল
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

# ২. GD এবং PHP এক্সটেনশনগুলো ইন্সটল ও কনফিগার করা
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৩. Composer ইন্সটল করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ৪. ওয়ার্কিং ডিরেক্টরি সেটআপ
WORKDIR /var/www

# ৫. প্রজেক্ট ফাইলগুলো কপি করা
COPY . .

# ৬. কম্পোজার দিয়ে ডিপেন্ডেন্সি ইন্সটল করা
RUN composer install --no-dev --optimize-autoloader

# ৭. পারমিশন সেটআপ (লারাভেলের জন্য জরুরি)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ৮. অ্যাপ্লিকেশন রান করার কমান্ড
CMD php artisan serve --host=0.0.0.0 --port=$PORT