FROM php:fpm

# Installer l'extension PDO SQLite
RUN docker-php-ext-install pdo pdo_sqlite

COPY . /var/www/html

WORKDIR /var/www/html