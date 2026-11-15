FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_CLI 0
ENV REAL_IP_HEADER 1

# Install dependency composer & berikan izin akses storage
RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache