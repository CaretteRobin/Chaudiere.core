FROM php:8.2-apache

# Active mod_rewrite pour les routes (Slim/Twig)
RUN a2enmod rewrite

# Installe les extensions nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    nano \
    vim \
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

# Installe Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Autoriser composer à tourner en root (docker)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Définit le document root Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Applique la config du nouveau document root à Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copie le code source dans le conteneur
COPY . /var/www/html

# Copie le .htaccess si besoin
COPY ./public/.htaccess /var/www/html/public/.htaccess

# Donne les bons droits à Apache
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Travaille dans le dossier projet
WORKDIR /var/www/html

# Installe les dépendances PHP via Composer
RUN if [ -f composer.json ]; then composer install --no-interaction --no-scripts --no-dev; fi

# Ajoute les headers CORS par défaut dans toutes les réponses
# (à compléter par middleware si tu veux du contrôle fin)
RUN echo 'Header set Access-Control-Allow-Origin "*"' >> /etc/apache2/apache2.conf

# Expose le port
EXPOSE 80
