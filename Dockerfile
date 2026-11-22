FROM composer:latest AS build

WORKDIR /build

RUN --mount=type=cache,target=/root/.composer/cache \
    --mount=type=bind,source=./my_app/composer.json,target=/build/composer.json,readonly \
    --mount=type=bind,source=./my_app/composer.lock,target=/build/composer.lock,readonly \
    composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

FROM php:8.2-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install redis && \
    docker-php-ext-enable redis

WORKDIR /app

RUN mkdir -p /app/var/cache/prod && \
    chown -R www-data:www-data /app/var/cache/prod

COPY --from=build /build/vendor ./vendor
COPY ./my_app .

# USER www-data
