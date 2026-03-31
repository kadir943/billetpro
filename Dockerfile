FROM php:8.0-apache 
COPY . /var/www/html/ 
RUN curl -sS https://getcomposer.org/installer 
RUN composer install --no-dev --optimize-autoloader 
ENV APACHE_DOCUMENT_ROOT /var/www/html/public 
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf 
EXPOSE 80 
