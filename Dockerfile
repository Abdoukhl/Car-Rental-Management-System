FROM php:8.2-fpm

# تثبيت التبعيات
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmcrypt-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع إلى داخل الحاوية
WORKDIR /var/www
COPY . .

# إعطاء صلاحيات
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# تشغيل php-fpm
CMD ["php-fpm"]
