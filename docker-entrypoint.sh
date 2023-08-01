#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html

#instructs the shell to run whatever command was passed in as an input argument next.
exec "$@" 