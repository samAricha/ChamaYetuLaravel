FROM php:8.2-fpm-alpine

ENV NGINX_VERSION 1.20.2
ENV NJS_VERSION   0.7.0
ENV PKG_RELEASE   1

RUN apk add --no-cache nginx wget nodejs-current npm

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf



# install necessary alpine packages
RUN apk update && apk add --no-cache \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    $PHPIZE_DEPS \
    libjpeg-turbo-dev

# compile native PHP packages
RUN docker-php-ext-install \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql




# configure packages
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

## install additional packages from PECL
##RUN pecl install zip && docker-php-ext-enable zip \
##    && pecl install igbinary && docker-php-ext-enable igbinary \
##    && yes | pecl install redis && docker-php-ext-enable redis
#
## install nginx
#RUN set -x \
#    && nginxPackages=" \
#        nginx=${NGINX_VERSION}-r${PKG_RELEASE} \
#        nginx-module-xslt=${NGINX_VERSION}-r${PKG_RELEASE} \
#        nginx-module-geoip=${NGINX_VERSION}-r${PKG_RELEASE} \
#        nginx-module-image-filter=${NGINX_VERSION}-r${PKG_RELEASE} \
#        nginx-module-njs=${NGINX_VERSION}.${NJS_VERSION}-r${PKG_RELEASE} \
#    " \
#    set -x \
#    && KEY_SHA512="e7fa8303923d9b95db37a77ad46c68fd4755ff935d0a534d26eba83de193c76166c68bfe7f65471bf8881004ef4aa6df3e34689c305662750c0172fca5d8552a *stdin" \
#    && apk add --no-cache --virtual .cert-deps \
#        openssl \
#    && wget -O /tmp/nginx_signing.rsa.pub https://nginx.org/keys/nginx_signing.rsa.pub \
#    && if [ "$(openssl rsa -pubin -in /tmp/nginx_signing.rsa.pub -text -noout | openssl sha512 -r)" = "$KEY_SHA512" ]; then \
#        echo "key verification succeeded!"; \
#        mv /tmp/nginx_signing.rsa.pub /etc/apk/keys/; \
#    else \
#        echo "key verification failed!"; \
#        exit 1; \
#    fi \
#    && apk del .cert-deps \
#    && apk add -X "https://nginx.org/packages/alpine/v$(egrep -o '^[0-9]+\.[0-9]+' /etc/alpine-release)/main" --no-cache $nginxPackages
#
#RUN ln -sf /dev/stdout /var/log/nginx/access.log \
#    && ln -sf /dev/stderr /var/log/nginx/error.log

# copy supervisor configuration
#COPY ./docker/supervisord.conf /etc/supervisord.conf




RUN mkdir -p /app
COPY . /app
#COPY ./src /app

# Install PHP extension http
RUN apk add --update --virtual .build-deps autoconf g++ make zlib-dev curl-dev libidn2-dev libevent-dev icu-dev libidn-dev
RUN pecl install raphf
RUN docker-php-ext-enable raphf
RUN pecl install pecl_http
RUN echo -e "extension=raphf.so\nextension=propro.so\nextension=iconv.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini
RUN rm -rf /usr/local/etc/php/conf.d/docker-php-ext-raphf.ini
RUN rm -rf /usr/local/etc/php/conf.d/docker-php-ext-propro.ini
RUN rm -rf /tmp/*

# Install composer
RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev




ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/



RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN cd /app npm install

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
