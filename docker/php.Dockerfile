FROM php:7.4-cli

RUN apt-get update -y \
    && apt-get install software-properties-common \
    # intl
    zlib1g-dev libicu-dev g++\
    # gd
    libzip-dev libpng-dev libmagickwand-dev libxml2-dev \
    -y \
    # extensions
    && docker-php-ext-install pdo_mysql intl gd \
    # cleaning
    && apt-get remove -y software-properties-common \
    && apt-get autoremove -y \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*