FROM php:8.1-apache

RUN a2enmod rewrite

WORKDIR /usr/local/apache2/htdocs/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions pdo pdo_mysql mysqli gd zip exif


# Setup Apache2 config
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf


RUN echo "ServerName TELECONTROL" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html