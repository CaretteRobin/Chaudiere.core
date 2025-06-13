FROM php:8.2-apache

# 1. Activer les modules Apache
RUN a2enmod rewrite headers

# 2. Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    nano \
    vim \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        mbstring \
        exif \
        gd \
        intl \
        xml \
    && rm -rf /var/lib/apt/lists/*

# 3. Installer Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Autoriser Composer en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Configurer le document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Copier les sources
COPY . /var/www/html

# 7. Copier .htaccess (optionnel si déjà inclus)
COPY ./public/.htaccess /var/www/html/public/.htaccess

# 8. Droits corrects
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# 9. Définir le working dir
WORKDIR /var/www/html

# 10. Installer les dépendances PHP (si composer.json présent)
RUN if [ -f composer.json ]; then composer install --no-interaction --no-scripts; fi

# 11. Ajouter les headers CORS (Header maintenant actif grâce à a2enmod headers)
RUN echo 'Header set Access-Control-Allow-Origin "*"' >> /etc/apache2/apache2.conf

# 12. Exposer le port
EXPOSE 80
