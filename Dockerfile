# Dockerfile
FROM php:8.3-apache

# Instala extensões necessárias para Laravel e PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip curl git \
    && docker-php-ext-install pdo pdo_pgsql

# Ativa o módulo rewrite do Apache
RUN a2enmod rewrite

# Copia a configuração customizada do Apache
COPY ./docker/apache/default.conf /etc/apache2/sites-available/000-default.conf

# Define o diretório padrão do Apache
WORKDIR /var/www/html

# Instala o Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copia os arquivos da aplicação
COPY . /var/www/html

# Ajusta permissões para o Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80