FROM php:7.2-fpm

# update / upgrade / install dependencies
RUN apt-get update -y && apt-get upgrade -y && apt-get install -y openssl zip unzip git zlib1g-dev nano gnupg2

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install more dependencies
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

# add composer to path
ENV PATH="~/.composer/vendor/bin:${PATH}"

# install laravel installer via composer
RUN composer global require "laravel/installer"

# install nodejs and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# install gd
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

EXPOSE 80
EXPOSE 443
EXPOSE 9000
