#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
#cp -R /var/www/html/.env.example /var/www/html/.env
chown -R www-data:www-data /var/www/html

#instructs the shell to run whatever command was passed in as an input argument next.
exec "$@" 