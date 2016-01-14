# dbCharts

## Installation

### Création de la BDD de developpement (uniquement pour développer)

Installer postgresql (si ce n'est déjà fait).

`sudo apt-get install postgresql`

Se placer dans le dossier 'setup_dev'.

`cd setup_dev`

Se connecter en tant qu'utilisateur 'postgres'.

`sudo su postgres`

Executer le script 'setup.sh'.

`./setup_dev.sh`

### Configuration

Lancer le script 'setup_rel.sh' en super-utilisateur à la racine du projet :

`sudo sh setup_rel.sh`

## Tests (uniquement pour développer)

Installer phpunit :

`sudo apt-get install phpunit`

Après avoir installé le projet, comme indiqué plus haut, exécuter à la racine du projet :

`phpunit --bootstrap vendor/autoload.php tests`

ou

`sh unittests.sh`

## Utilisation

Ouvrir la page 'web/index.html' avec les paramètres de la forme :

`web/index.html?tableName=<table_name>&sensorIdColumn=<sensors_id_column_name>&valuesColumn=<values_column_name>&timestampColumn=<timestamp_column_name>&sensorIds=[<id>,<id>...]&startTime=<start_timestamp>&endTime=<end_timestamp>`

Par exemple :

`web/index.html?tableName=measurments&sensorIdColumn=sensor_id&valuesColumn=value&timestampColumn=timestamp&sensorIds=[70,72]&startTime=1417962686.2894&endTime=141818181881.2399`