FROM php:8.2-apache

# Active mod_rewrite pour les routes Slim
RUN a2enmod rewrite

# Installe les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Active .htaccess et redirige tout vers public/
COPY ./public/.htaccess /var/www/html/public/.htaccess

# Définit le bon DocumentRoot (public/)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Applique le DocumentRoot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
