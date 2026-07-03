# ১. লারাভেলের লেটেস্ট ভার্সনের সাথে সামঞ্জস্য রাখতে 8.4-fpm ব্যবহার করুন
FROM php:8.4-fpm

# ২. সিস্টেম প্যাকেজ এবং প্রয়োজনীয় লাইব্রেরি ইন্সটল
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

# ৩. GD এবং PHP এক্সটেনশনগুলো ইন্সটল ও কনফিগার করা
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# ৪. Composer ইন্সটল করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ৫. ওয়ার্কিং ডিরেক্টরি সেটআপ
WORKDIR /var/www

# ৬. প্রজেক্ট ফাইলগুলো কপি করা
COPY . .

# ৭. কম্পোজার দিয়ে ডিপেন্ডেন্সি ইন্সটল করা (ফিক্সড লাইন)
# --ignore-platform-reqs যোগ করা হয়েছে যাতে ভার্সন কনফ্লিক্ট বিল্ড আটকে না দেয়
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# ৮. পারমিশন সেটআপ
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ৯. অ্যাপ্লিকেশন রান করার কমান্ড
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT