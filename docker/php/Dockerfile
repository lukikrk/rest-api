ARG APP_MODE=dev

FROM php:8.3.10-fpm AS base

WORKDIR /opt/app/

RUN usermod -u 1000 www-data

RUN apt update && apt install -y git htop libpq-dev libicu-dev zlib1g-dev libzip-dev nginx procps supervisor zip unzip
RUN docker-php-ext-install intl opcache pdo pdo_mysql zip && docker-php-ext-enable intl

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY /docker/http/conf.d/nginx.conf /etc/nginx/conf.d/default.conf
COPY /docker/php/conf.d/php-fpm.conf /usr/local/etc/php-fpm.d/zz-www.conf
COPY /docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY /docker/php/conf.d/supervisor.conf /etc/supervisor/conf.d/supervisor.conf
COPY /docker/php/scripts/startapp.sh /

RUN chmod +x /startapp.sh

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]

FROM base AS dev

RUN pecl install xdebug

COPY /docker/php/conf.d/xdebug.off.ini /usr/local/etc/php/conf.d/xdebug.off
COPY /docker/php/scripts/init.sh /
COPY /docker/php/scripts/xoff.sh /usr/bin/xoff
COPY /docker/php/scripts/xon.sh /usr/bin/xon

RUN chmod +x /init.sh /usr/bin/xoff /usr/bin/xon
RUN mkdir /var/www/.cache && chown www-data:www-data /var/www/.cache

RUN /init.sh

FROM base AS prod

FROM ${APP_MODE} AS final
