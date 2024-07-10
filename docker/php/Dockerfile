FROM composer:latest AS composer

FROM php:8.3-fpm-alpine3.20

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
    git \
    unzip

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
