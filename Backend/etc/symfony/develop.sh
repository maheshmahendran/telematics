#!/usr/bin/env bash
set -e

# Overwrite the default varnish config (/etc/varnish/default.vcl) to disable caching in development
cp /var/www/html/etc/varnish/default_dev.vcl /etc/varnish/default.vcl

cd /var/www/html
rm -rf var/cache/*
composer --no-ansi install
chown -R www-data:www-data /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions
chmod -R 777 /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions

service varnish start
service nginx start
/usr/sbin/apache2 -D FOREGROUND
