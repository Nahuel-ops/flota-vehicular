FROM php:8.3-apache

# Instalar dependencias del sistema y extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar el módulo de reescritura de Apache para Laravel
RUN a2enmod rewrite

# Cambiar el DocumentRoot de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el código del proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Instalar Composer de forma global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ejecutar la instalación de dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Dar los permisos correctos a las carpetas de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Comando por defecto para iniciar Apache en el puerto correcto de Render
CMD ["apache2-foreground"]
