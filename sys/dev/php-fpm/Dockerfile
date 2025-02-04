FROM php:8.0-fpm-alpine

ENV RUN_IN_CONTAINER="True"

WORKDIR "/application"

RUN apk add --no-cache --virtual .builddeps \
        autoconf \
        g++ \
        gcc \
        make \
        unzip \
        wget \
    && apk add --no-cache \
        freetype-dev \
        git \
        icu-dev \
        jpeg-dev \
        libpng-dev \
        libzip-dev \
        oniguruma-dev \
        yaml-dev \
        zlib-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        gd \
        intl \
        mbstring \
        opcache \
        zip \
    && wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.6.0/pickle.phar -O /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle \
    && pickle install yaml@2.1.0 --defaults --no-interaction \
    && pickle install redis@5.3.2 --defaults --no-interaction \
    && ln -nfs /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

## REF: https://github.com/docker-library/php/issues/240
#RUN apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing gnu-libiconv
#ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so
## REF NEW: https://github.com/docker-library/php/issues/1121#issuecomment-886817367
RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.13/community/ gnu-libiconv=1.15-r3
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN mkdir -p /application/var/cache && chmod 777 /application/var/cache
RUN mkdir -p /application/var/log && chmod 777 /application/var/log

EXPOSE 9000

CMD ["php-fpm", "-F"]
