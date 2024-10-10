# Usar una imagen oficial de PHP con Apache como base
FROM php:8.3-apache

# Instalar dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos de la aplicación al contenedor
COPY . /var/www/html

# Instalar las dependencias de Composer
RUN composer install --no-scripts --no-autoloader

# Generar archivos autoload optimizados
RUN composer dump-autoload --optimize

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 755 /var/www/html/storage

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]
