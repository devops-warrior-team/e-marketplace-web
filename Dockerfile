# Stage 1: Install dependencies and prepare application code
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts

# Stage 2: Build the actual Docker image
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk --update add --no-cache libzip-dev zip unzip
RUN docker-php-ext-install pdo pdo_mysql zip

# Set the working directory
WORKDIR /var/www/html

# Copy Laravel application files from the composer stage
COPY --from=composer /app/vendor ./vendor
COPY . .

# Set appropriate permissions for Laravel directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Remove unnecessary system packages and clean up
#RUN apk del libzip-dev zip unzip && \
#    rm -rf /var/cache/apk/*

RUN rm -rf /var/cache/apk/*

# Expose the PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]