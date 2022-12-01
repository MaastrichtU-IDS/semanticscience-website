FROM php:apache

RUN a2enmod rewrite

COPY .htaccess /var/www/html