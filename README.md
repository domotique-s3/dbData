# dbCharts

## Prerequis

### Apache2

Apache 2 doit être installé.

La dossier de dbCharts doit être placé dans un dossier d'apache (par defaut '/var/www/html/').

### PHP5

PHP5 doit être installé.

### Un SGBD

Postgresql et Mysql sont pris en charge par dbCharts.

### Une base de données

Cette base de données doit contenir une table contenant 3 champs (les noms de la table et des champs ne sont pas imposés) :

- ID du capteur, de type INT
- Valeur de la mesure, de type DOUBLE PRECISION
- Horodatage, de type DOUBLE PRECISION

## Configuration

Lancer le script 'setup_rel.sh' en super-utilisateur à la racine du projet :

`sudo sh setup_rel.sh`

## Utilisation

Ouvrir la page 'web/index.html' avec les paramètres de la forme :

`web/index.html?sensorIdColumn=<sensors_id_column_name>&valuesColumn=<values_column_name>&timestampColumn=<timestamp_column_name>&sensors[<table_name>]=[<id>,<id>...]&start=<start_timestamp>&end=<end_timestamp>`

Par exemple :

`web/index.html?sensorIdColumn=sensor_id&valuesColumn=value&timestampColumn=timestamp&sensors[measurments]=[70,72]&start=1417962686.2894&end=141818181881.2399`
