FROM php:8.2-apache

# Enable necessary Apache and PHP modules
RUN a2enmod rewrite && docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y libpng-dev && docker-php-ext-install gd

# Configure PHP upload limits
RUN echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 60" >> /usr/local/etc/php/conf.d/uploads.ini

# Configure file uploads directory
RUN mkdir -p /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 755 /var/www/html/uploads

# Copy project files
COPY . /var/www/html/
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80
CMD ["apache2-foreground"]
