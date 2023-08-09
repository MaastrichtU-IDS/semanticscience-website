FROM php:7.1-apache

RUN a2enmod rewrite

COPY .htaccess /var/www/html