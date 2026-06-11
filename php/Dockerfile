FROM wordpress:php8.5-fpm

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/conf.d/custom.ini
