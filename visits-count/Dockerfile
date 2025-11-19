FROM php:8.1-apache

# Copy application files
COPY index.php /var/www/html/
# COPY auto-reload.sh /usr/local/bin/auto-reload.sh
# RUN chmod +x /usr/local/bin/auto-reload.sh

EXPOSE 80
CMD ["apache2-foreground"]