FROM php:8.1-fpm

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_sqlite

# Définir le répertoire de travail
WORKDIR /var/www/html