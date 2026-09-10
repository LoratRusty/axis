FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip nginx \
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

RUN echo 'server {\n\
    listen 8080;\n\
    root /app/public;\n\
    index index.php;\n\
    location / { try_files $uri $uri/ /index.php?$query_string; }\n\
    location ~ \\.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/sites-available/default

EXPOSE 8080

CMD ["sh", "-c", "php-fpm -D && php artisan migrate --force && php artisan config:cache && php artisan route:cache && nginx -g 'daemon off;'"]