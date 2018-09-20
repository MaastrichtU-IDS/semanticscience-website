FROM php:7-apache

MAINTAINER Alexander Malic <alexander.malic@maastrichtuniversity.nl>
MAINTAINER Michel Dumontier <michel.dumontier@maastrichtuniversity.nl>

ARG APP_ENV=prod

RUN apt-get update && apt-get install -y git zip virtuoso-minimal && \
  a2enmod rewrite && \
  a2enmod headers && \
  echo "Header set Access-Control-Allow-Origin \"*\"" >> /etc/apache2/sites-available/000-default.conf
  
# WORKDIR /tmp
# RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

#WORKDIR /var/www/html
#COPY . .

# RUN composer install

EXPOSE 80
