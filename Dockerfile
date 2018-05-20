FROM php:7.2-apache

ADD virtual_host.conf /etc/apache2/sites-available/000-default.conf
ADD app /var/www/html

RUN a2enmod rewrite
