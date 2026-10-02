FROM php:8.2-apache

RUN docker-php-ext-install mysqli && a2enmod rewrite

COPY . /var/www/html/

# Файлы с флагами вне web-директории
RUN echo 'flag{;cat_/etc/passwd}' > /flag_cmd.txt && \
    echo 'flag{../../../../etc/passwd}' > /flag_lfi.txt

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
