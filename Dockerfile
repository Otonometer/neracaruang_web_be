FROM php:8.1-apache

# Set workdir
WORKDIR /var/www/webcore_app

# Copy all files
COPY . .

RUN cp kubernetes/default.conf /etc/apache2/sites-enabled/000-default.conf

## View files
RUN ls -la

ARG CONTAINER_MODE=app

# Update package
RUN apt-get update -yqq && apt-get install gnupg -yqq

RUN apt-get install git libzip-dev libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev unixodbc-dev libpq-dev libpcre3-dev libtidy-dev libonig-dev libsodium-dev wget fontconfig libxrender1 xfonts-75dpi xfonts-base xfonts-utils libfontenc1 x11-common xfonts-encodings -yqq

# install ext
RUN docker-php-ext-install pdo_mysql mbstring curl intl gd xml zip bz2 opcache sodium exif sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
RUN php artisan key:generate || true
RUN php artisan optimize:clear || true
RUN php artisan storage:link || true

RUN php composer.phar dump-autoload || true

RUN a2enmod rewrite

RUN chmod +x artisan

RUN chmod +x entrypoint.sh
RUN chmod -R 755 storage

COPY kubernetes/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

ENTRYPOINT ["./entrypoint.sh"]

