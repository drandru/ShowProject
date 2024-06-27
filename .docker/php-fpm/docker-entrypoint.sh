#!/bin/bash

# Stop on any error

if [ ! -f '/app/storage/init' ]; then
  sleep 10; # wait for DB

  echo 'Init container'
  php artisan migrate
  php artisan orchid:admin admin admin@admin.com admin

  touch /app/storage/init

fi

php-fpm -O -F
