FROM php:8.3-cli

# 1. Install dependency dasar & curl
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 2. Unduh installer ekstensi PHP langsung dari GitHub (Bypass Docker Hub error)
RUN curl -sSL -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions

# 3. Install ekstensi PHP
RUN install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. Copy source code
COPY . .

# 6. Buat struktur folder storage & permission
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# 7. Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 8. Set Port ke 3000 sesuai kebutuhan EthioDeploy
EXPOSE 3000

# 9. Jalankan Laravel di Port 3000
CMD ["sh", "-c", "php artisan config:clear && php artisan serve --host=0.0.0.0 --port=3000"]