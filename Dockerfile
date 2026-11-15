FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_CLI 0
ENV REAL_IP_HEADER 1
