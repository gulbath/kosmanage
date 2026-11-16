FROM php:8.3-cli

# Copy extension installer yang sudah terkompilasi
COPY --from=mlocati/docker-php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/

# Install sistem dependency esensial
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP menggunakan pre-compiled binaries (cepat & hemat resource)
RUN install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Composer dari official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy kode aplikasi
COPY . .

# Install dependency composer tanpa dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]