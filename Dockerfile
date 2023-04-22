#FROM php:7.4-fpm
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y     libzip-dev     zip     && docker-php-ext-configure zip     && docker-php-ext-install zip pdo_mysql

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=8000
