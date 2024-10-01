# Menggunakan base image PHP 7 dan Nginx
FROM php:7.4-fpm-alpine

# Install dependencies
RUN apk update && apk add --no-cache \
    nginx \
    curl \
    bash \
    git \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    libzip-dev \
    oniguruma-dev

# Install PHP extensions yang dibutuhkan CodeIgniter
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl

# Copy konfigurasi Nginx
COPY ./nginx.conf /etc/nginx/nginx.conf

# Copy kode aplikasi CodeIgniter ke dalam container
COPY . /var/www/html

# Berikan izin ke folder CodeIgniter
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy konfigurasi supervisor
COPY ./supervisord.conf /etc/supervisord.conf

# Expose port untuk Nginx
EXPOSE 80

# Start supervisor untuk menjalankan Nginx dan PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]