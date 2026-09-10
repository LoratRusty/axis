FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libicu-dev libgd-dev libpng-dev \
    libonig-dev libxml2-dev \
    && docker-php-ext-install intl zip gd pdo pdo_mysql mbstring bcmath opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction
RUN npm install && npm run build
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache

EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php -S 0.0.0.0:$PORT -t public"]