#!/bin/bash

mv /usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.off

sed -i "s|opcache.enable =.*|opcache.enable = 1|" $PHP_INI_DIR/conf.d/custom.ini
sed -i "s|opcache.enable_cli =.*|opcache.enable_cli = 1|" $PHP_INI_DIR/conf.d/custom.ini

pkill -o -USR2 php-fpm
