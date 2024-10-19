FROM php:8.1-fpm

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Définir le répertoire de travail
WORKDIR /var/www/html

# Commande pour maintenir PHP-FPM en fonctionnement
CMD ["php-fpm"]