FROM php:5.6-apache

MAINTAINER Alexander Malic <alexander.malic@maastrichtuniversity.nl>
MAINTAINER Michel Dumontier <michel.dumontier@maastrichtuniversity.nl>

ARG APP_ENV=prod

RUN apt-get update && apt-get install -y git zip virtuoso-minimal nano && \
  a2enmod rewrite && \
  a2enmod headers && \
  echo "Header set Access-Control-Allow-Origin \"*\"" >> /etc/apache2/sites-available/000-default.conf 

WORKDIR /loader

COPY startup.sh /usr/local/bin/startup.sh

EXPOSE 80

ENTRYPOINT ["startup.sh"]
