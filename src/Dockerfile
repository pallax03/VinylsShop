# Use the official PHP-Apache image
FROM php:8.1-apache

# add mysqli dependency
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Configure Apache to allow .htaccess files
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# COPY THOSE FILES INTO THE CONTAINER
COPY ./ /var/www/html

# Set the working directory to the web root
WORKDIR /var/www/html