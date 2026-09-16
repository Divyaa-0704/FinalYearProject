FROM php:8.2-apache

# Install required PHP extensions for MySQL (mysqli and pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files into the web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set proper ownership for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80

# Run Apache in foreground
CMD ["apache2-foreground"]
