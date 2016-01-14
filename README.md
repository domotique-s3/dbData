# dbCharts

## Installation

### Création de la BDD de developpement

Installer postgresql (si ce n'est déjà fait).

`sudo apt-get install postgresql`

Se placer dans le dossier 'setup'.

`cd setup`

Se connecter en tant qu'utilisateur 'postgres'.

`sudo su postgres`

Executer le script 'setup.sh'.

`./setup.sh`

### Configuration

Installer Composer : 

`php -r "readfile('https://getcomposer.org/installer');" | php`

`php composer.phar install`

Lancer `php db_setup.php` pour configurer PDO.

## Tests

Installer phpunit :

`sudo apt-get install phpunit`

Après avoir installé le projet, comme indiqué plus haut, exécuter à la racine du projet :

`phpunit --bootstrap vendor/autoload.php tests`

ou

`sh unittests.sh`