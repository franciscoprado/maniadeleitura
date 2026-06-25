FROM wordpress:php8.5-fpm

RUN apt-get update \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install soap \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

COPY php.ini /usr/local/etc/php/conf.d/custom.ini
