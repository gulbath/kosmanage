FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_CLI=0
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV SKIP_COMPOSER=1

# Install dependency saat proses build & atur izin folder storage
RUN composer install --no-dev --prefer-dist --optimize-autoloader --ignore-platform-reqs && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache