FROM composer:latest AS build

WORKDIR /build

RUN --mount=type=cache,target=/root/.composer/cache \
    --mount=type=bind,source=./my_app/composer.json,target=/build/composer.json,readonly \
    --mount=type=bind,source=./my_app/composer.lock,target=/build/composer.lock,readonly \
    composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

FROM php:8.2-fpm

WORKDIR /app

COPY --from=build /build/vendor ./vendor
COPY ./my_app .

RUN mkdir -p /app/var/cache && \
    chown -R www-data:www-data /app/var/cache

USER www-data
