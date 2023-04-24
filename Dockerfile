FROM php:8.2-fpm

RUN apt-get update \
&& apt-get install -y libzip-dev zip \
&& docker-php-ext-configure zip \
&& docker-php-ext-install zip pdo_mysql \
&& pecl install redis \
&& docker-php-ext-enable redis

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
#RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=8000
