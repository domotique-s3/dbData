#!/bin/bash

php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar install

echo ""

sudo rm -f pdo.cfg
php setup_rel/db_setup.php
sudo chown www-data pdo.cfg
sudo chmod 700 pdo.cfg
