FROM php:8.2-apache

# Install PostgreSQL client library & ekstensi pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Salin seluruh file jobsheet13 ke root web server Apache
COPY . /var/www/html/

# Atur kepemilikan file untuk Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
