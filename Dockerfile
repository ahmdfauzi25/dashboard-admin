FROM php:8.2-apache

# Install dependencies (PHP + Node.js + NPM)
RUN apt-get update && apt-get install -y \
    zip unzip git curl gnupg2 ca-certificates lsb-release \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Composer files dulu (supaya cache build lebih efisien)
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy seluruh source Laravel
COPY . .

# Pastikan direktori cache & storage ada dan writable sebelum Composer scripts jalan
RUN mkdir -p \
    bootstrap/cache \
    storage/app \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
  && chown -R www-data:www-data /var/www/html \
  && chmod -R 775 storage bootstrap/cache

# Laravel optimize
RUN composer dump-autoload --optimize

# Apache VirtualHost untuk Laravel
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Set permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
