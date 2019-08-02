FROM php:7.2.0-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client git zip unzip libzip-dev libmagickwand-dev --no-install-recommends && \
    pecl install mcrypt-1.0.1 && \
    docker-php-ext-enable mcrypt && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip

# Node.js
RUN curl -sL https://deb.nodesource.com/setup_12.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install nodejs -y
RUN npm install npm@6.9.0 -g
RUN command -v node
RUN command -v npm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
