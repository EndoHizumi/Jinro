FROM php:7.2.7-apache
RUN apt update && apt install -y libtidy-dev git libzip-dev zlib1g-dev
RUN docker-php-ext-install pdo_mysql mbstring tidy zip\