FROM php:8.3-cli-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    mysql-client \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_mysql bcmath

# Copy composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP and Node dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

EXPOSE 8080

CMD ["sh", "-c", "php artisan storage:link || true && php artisan config:clear && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
