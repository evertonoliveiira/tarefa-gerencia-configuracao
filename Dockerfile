# Dockerfile
FROM php:8.3-apache

# ───── Instalar Node.js (v20), extensões PHP e habilitar mod_rewrite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get update \
  && apt-get install -y \
       nodejs \
       libpq-dev \
       zip unzip curl git \
  && docker-php-ext-install pdo pdo_pgsql \
  && a2enmod rewrite \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

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