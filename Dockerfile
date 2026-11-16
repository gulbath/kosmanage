FROM php:8.3-cli

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Unduh extension installer via GitHub Releases
RUN curl -sSL -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions

# Install ekstensi PHP Laravel
RUN install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code
COPY . .

# Buat folder storage & atur izin akses
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Install paket composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Bind port dinamis sesuai variabel $PORT milik Render
CMD ["sh", "-c", "php artisan config:clear && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]