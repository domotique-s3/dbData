# dbData

## 1. Prérequis

- Un serveur web
- PHP >= 5.4
- Un SGBD

## 2. Installation pour utilisation

### 2.1 Si votre SGBD est Postgresql

Installer le driver pgsql :

`sudo apt-get install php5-pgsql`

Relancer apache2 :

`sudo service apache2 restart`

### 2.2 Configuration

Lancer le script 'setup_rel.sh' en super-utilisateur à la racine du projet :

`sudo sh bin/setup_rel.sh`

##  3. Installation pour développement

### 3.1 Création de la BDD

Installer postgresql (si ce n'est déjà fait).

`sudo apt-get install postgresql`

Se placer dans le dossier 'bin/dev'.

`cd bin/dev`

Se connecter en tant qu'utilisateur 'postgres'.

`sudo su postgres`

Executer le script 'setup.sh'.

`./setup_dev.sh`

### 3.2 Configuration

Voir 2.2.

> Les informations d'authentification à la base de données de développement sont :
> - Nom de la base : dbcharts
> - Host : localhost
> - Login : dbcharts
> - Mot de passe : pass

### 3.3 Tests

Installer phpunit :

`sudo apt-get install phpunit`

Après avoir installé le projet, comme indiqué plus haut, exécuter à la racine du projet :

`phpunit --bootstrap vendor/autoload.php tests`

ou

`sh unittests.sh`

## 4. Utilisation

Ouvrir la page 'web/dbCharts.php' avec les paramètres de la forme :

`dbData.php?sensorIdColumn=sensor_id&valuesColumn=value&timestampColumn=timestamp&start=1417962686.2894&end=1418176473.2971&sensors[measurments]=[63,34,78]`
