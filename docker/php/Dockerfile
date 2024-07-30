FROM composer:latest AS composer

FROM php:8.3-fpm-alpine3.20

COPY --from=composer /usr/bin/composer /usr/bin/composer

ARG XDEBUG_VERSION=3.3.2

RUN apk update \
    && apk upgrade --no-cache \
    && apk add --no-cache $PHPIZE_DEPS linux-headers git mysql-client zip unzip icu-dev git unzip \
    && pecl install xdebug-$XDEBUG_VERSION \
    && docker-php-ext-install \
       bcmath \
       mysqli \
       intl \
       pdo_mysql \
    && apk del $PHPIZE_DEPS linux-headers \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
