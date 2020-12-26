FROM php:7.4-apache
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y git
  
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer