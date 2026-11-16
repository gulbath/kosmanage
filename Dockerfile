FROM php:8.3-cli

# Copy extension installer biner
COPY --from=mlocati/docker-php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP esensial
RUN install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code
COPY . .

# Buat struktur folder storage laravel & atur permission
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Install composer packages
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000

# Jalankan clearing cache sebelum serve
CMD ["sh", "-c", "php artisan config:clear && php artisan serve --host=0.0.0.0 --port=8000"]