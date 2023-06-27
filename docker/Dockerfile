FROM php:8.0-apache

RUN apt-get update &&\
apt-get install nano

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html

EXPOSE 80