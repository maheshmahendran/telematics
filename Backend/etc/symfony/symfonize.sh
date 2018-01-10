#!/usr/bin/env bash
set -e

cd /var/www/html
rm -rf var/cache/*
composer --no-ansi install
chown -R www-data:www-data /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions
chmod -R 777 /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions

service varnish start
service nginx start
service cron start

/usr/sbin/apache2 -D FOREGROUND
