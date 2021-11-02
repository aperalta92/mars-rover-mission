FROM php:8.0-apache

RUN mkdir /etc/apache2/logs

RUN apt-get update && apt-get install -y --fix-missing libmcrypt-dev locales locales-all cronolog \
   libjpeg62-turbo-dev libmcrypt-dev libssl-dev libjpeg-dev libpng-dev libfreetype6-dev \
   libzip-dev zip unzip libicu-dev libxslt-dev git cron nodejs npm \
   mariadb-client libmagickwand-dev --no-install-recommends \
   && docker-php-ext-install pdo_mysql bcmath soap \
   && docker-php-ext-configure intl \
   && docker-php-ext-install intl \
   && docker-php-ext-install xsl \
   && docker-php-ext-install zip

RUN a2enmod ssl
RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/usr/bin
