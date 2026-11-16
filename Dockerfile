FROM php:8.3-cli

# Install ekstensi PHP yang dibutuhkan Laravel & MySQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Composer resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy seluruh source code
COPY . .

# Install dependensi Laravel PHP 8.3
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Atur izin akses folder storage & cache
RUN chmod -R 777 storage bootstrap/cache

# Jalankan server yang langsung mendengarkan 0.0.0.0 dan port dinamis $PORT dari EthioDeploy
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]