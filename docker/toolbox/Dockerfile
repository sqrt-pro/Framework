FROM php:5.6-cli

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        git \
        mc \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
        iconv \
        mcrypt \
        pdo_mysql \
        mbstring

# Install composer
RUN curl -sS# https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY ./config /usr/local/etc/php/conf.d

WORKDIR /app

ENTRYPOINT ["/bin/bash"]