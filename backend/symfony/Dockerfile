# Usa la imagen oficial de PHP 8
FROM php:8.1-cli

# Instala las extensiones necesarias
RUN docker-php-ext-install pdo_mysql

# Configura el entorno
WORKDIR /var/www/html

# Copia los archivos de la aplicación Symfony
COPY . .

# Instala las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-interaction

# Descarga e instala Symfony CLI usando curl
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Limpia el sistema
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala las dependencias de Symfony
RUN composer install

# Exponer el puerto 8000 para el servidor incorporado de Symfony
EXPOSE 8000

# Comando para ejecutar el servidor web de Symfony
# CMD ["symfony", "server:start"]
CMD ["symfony", "clear:cache"]
# CMD ["php", "bin/console", "server:start"]