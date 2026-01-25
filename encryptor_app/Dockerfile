FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
