#!/bin/bash
cd /var/www/html
ls -la

echo Checking database availability...
while ! mysqladmin ping -h mysql --silent; do
    sleep 1
done

CONTAINER_ALREADY_STARTED=/var/www/html/firstrun
if [ ! -e $CONTAINER_ALREADY_STARTED ]; then
    echo "-- First container startup --"
    composer install --no-scripts --no-dev --prefer-dist
else
    echo "-- Not first container startup --"
fi

composer dump-autoload

php artisan view:clear
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan config:cache

if [ ! -e $CONTAINER_ALREADY_STARTED ]; then
    touch $CONTAINER_ALREADY_STARTED
    php artisan migrate --force
fi

php artisan db:seed --force

chown -R www-data /var/www/html/storage
chmod -R 0770 /var/www/html/storage

a2dissite 000-default.conf
a2ensite laravel.conf
a2enmod rewrite headers

dumb-init apachectl -D FOREGROUND
