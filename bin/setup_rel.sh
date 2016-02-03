#!/bin/bash

php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar install

echo ""

sudo rm -f pdo.cfg
sudo touch app/pdo.cfg
php bin/console db-config
sudo chown www-data:www-data app/pdo.cfg
sudo chmod 700 app/pdo.cfg
