FROM php:8.2-apache

# Active mod_rewrite pour les routes Slim/Twig
RUN a2enmod rewrite

# Installe les extensions nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Installe Composer (depuis image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le document root Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Appliquer la config Apache avec le nouveau document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copie du code source
COPY . /var/www/html

# Copie du .htaccess si nécessaire
COPY ./public/.htaccess /var/www/html/public/.htaccess

# Autoriser l’exécution de composer en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installation des dépendances PHP
WORKDIR /var/www/html
RUN if [ -f composer.json ]; then composer install --no-interaction --no-scripts; fi
