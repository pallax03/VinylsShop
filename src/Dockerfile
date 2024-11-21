# Use the official PHP-Apache image
FROM php:8.1-apache

# add mysqli dependency
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable mod_rewrite for Apache and configure Apache to allow .htaccess files
RUN a2enmod rewrite && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# https is not enabled by default
# # Enable SSL module and default SSL site
# RUN a2enmod ssl
# RUN a2ensite default-ssl

# # Copy SSL certificates into the container
# COPY ./certs/selfsigned.crt /etc/apache2/ssl/selfsigned.crt
# COPY ./certs/selfsigned.key /etc/apache2/ssl/selfsigned.key

# # Copy Apache SSL configuration
# COPY ./apache2/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# # Enable the SSL site
# RUN a2ensite default-ssl

# COPY THOSE FILES INTO THE CONTAINER
COPY ./ /var/www/html

# Set the working directory to the web root
WORKDIR /var/www/html