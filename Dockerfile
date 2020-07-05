FROM php:7.4-apache

RUN apt update && apt upgrade -y
RUN apt install wget -y
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite
RUN a2enmod ssl
WORKDIR /var/www/html

COPY . .
COPY ./httpd/sites-enabled /etc/apache2/sites-enabled

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN php composer.phar install --no-interaction

CMD [ "apache2-foreground" ]

EXPOSE 80 443