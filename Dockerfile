# Usa una imagen base con PHP y Apache
FROM php:8.1-apache

# Instala extensiones de PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia el código fuente de tu proyecto al contenedor
COPY . /var/www/html/

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html/

# Expone el puerto en el que se ejecuta Apache
EXPOSE 80

# Comando para ejecutar Apache en primer plano
CMD ["apache2-foreground"]

RUN a2enmod rewrite
