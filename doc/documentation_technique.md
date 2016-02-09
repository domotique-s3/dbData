# Projet Domotique S3 - dbData

#### Documentation technique

## Introdution

Le projet *Domotique S3* vise à générer des graphiques représentant des données enregistrées par des capteurs dans une base de données.

*dbData* est la partie du projet qui permet la relation entre dbCharts, qui génère les graphiques, et la base de données. Ce programme est développé en PHP et est destiné à être exécuté par un serveur web tel que Apache2. Son but est de recevoir une requête HTTP, dans laquelle sont spécifiés les paramètres du graphique (nom des tables, noms des colonnes, IDs des capteurs, etc.), d'interroger la base de données et de formater les données pour les renvoyer via le protocole HTTP.

## Cahier des charges

### Format de la base de données

La base de données doit être composée d'au moins une table qui contient les valeurs enregistrées par les capteurs, ces tables doivent contenir les colonnes :

- Identifiant du capteur (INTEGER)
- Valeur enregistrée (DOUBLE PRECISION)
- Horodatage de la mesure (DOUBLE PRECISION)

> Si la base de données contient plusieurs tables de ce type et qu'une requête porte sur plusieurs de ces tables en même temps, leurs colonnes doivent obligatoirement avoir le même nom.

### Requête HTTP

La requête envoyée à dbData doit contenir les informations suivantes :

- Le nom de la colonne des identifiants des capteurs
- Le nom de la colonne des valeurs enregistrées
- Le nom de la colonne des horodatages
- Les horodatages de début et de fin (optionnels, par défaut toutes les entrées seront renvoyées)
- Les noms des tables (au moins une) et la liste des capteurs de chaque table

Ces informations seront transmises dans l'URL via le protocole GET :

- `sensorIdColumn` : colonne des IDs des capteurs
- `valuesColumn` : colonne des valeurs
- `timestampColumn` : colonne des horodatages
- `start` : horodatage de début (optionel)
- `end` : horodatage de fin (optionel)
- `sensors[<nom_table>]` : liste des capteurs d'une table de la forme `[<id>, <id>, ...]` (au moins un ID)

Un exemple d'URL pourrai être :

`<lien_vers_dbData>?sensorIdColumn=sensor_id&valuesColumn=value&timestampColumn=timestamp&start=1417962686.2894&end=1418176473.2971&sensors[measurments]=[63,34,78]&sensors[othertable]=[102]`

- Colonne des IDs : *sensor_id*
- Colonne des valeurs : *value*
- Colonne des horodatages : *timestamp*
- Horodatage de début : 1417962686.2894
- Horodatage de fin : 1418176473.2971
- Capteurs des tables :
    - *measurments* : 63, 34 et 78
    - *othertable* : 102

### Réponse

La réponse est renvoyée via le protocole HTTP et est au format JSON.

// TODO : Peut contenir soit les données soit les erreurs
// TODO : Format des données
// TODO : Format des erreurs
// TODO : Erreurs possibles

## Documentation des classes

### `namespace Framework`

Contient les classes nécessaires au programme mais qui ne sont pas spécifique au projet, elle pourraient être réutilisées dans d'autres programmes.

### `namespace Application`

Contient les classes spécifique du projet.

### `class Framework/Filesystem/File`

Permet la lecture et écriture des fichiers.
Cette classe a été créée pour simplifier la lecture et écriture dans les fichiers.

`__construct($path)` prend en paramètre le chemin du fichier, il sera ouvert en lecture et écriture et sera créé s'il n'existe pas. Le fichier est formé lors de l'appel du desctructeur.

La méthode statique `exists($path)` renvoit *true* si le fichier spécifié par le chemin `$path` existe et *false* sinon.

`write($str)` écrit le string `$str` à la fin du fichier.

`read()` retourne le contenu du fichier.

`clear()` efface le contenu du fichier.

### `namespace Framework/Form`

// TODO : Tu peux le faire Loïc ?

### `class Framework/HTTP/ParameterBag`

Est constitué d'un tableau associatif et définit des méthodes permettant de le manipuler.

### `class Framework/HTTP/Request`

Représente la requête reçue (URL).
Cette classe est composée de trois *ParameterBag* :

- `$query` qui contient les paramètres de la requête
- `$attributes` qui contient des éventuels paramètres additionels
- `$server` qui contient les paramètres du serveur

`fromGlobals()` construit un objet de type `Request` à partir des variables superglobales (`$_GET`, ...).

### `class Framework/HTTP/Response`

Représente la réponse HTTP qui sera renvoyée. Cette réponse est constituée d'un contenu (texte) et d'un code HTTP.

`send()` envoi la réponse.

### `class Framework/HTTP/JsonHandler`

Permet de formater des objets au format JSON.

`encode($data)` formate un objet.

### `class Framework/Logger/Logger`

Permet d'écrire les logs du programme. Le constructeur de cette classe prend en paramètre un objet de type `File` dans lequel seront écrits les logs.

`message($message, $timer = false)` écrit un message dans les logs, si *timer* est égal à true, un timer sera lancé jusqu'à l'appel de la méthode `done()`

`done()` écrit "Done (<temps> ms)" où *temps* est remplacé par le temps en millisecondes depuis que le timer a été lancé.

### `class Framework/Logger/LoggerAwareInterface`

Un classe qui implémente cette interface devra implémenter la méthode `setLogger(Logger $logger)`.

## Fonctionnement du programme

La page à laquelle est envoyée la requête se trouve dans le dossier *web/* et se nomme *dbData.php*, ce script PHP va instancier les différents objets nécessaires à la lecture de la requête, la récupération des données auprès de la base de données puis la structuration et l'envoi de la réponse.

### `Récupération des paramètre de l'URL`

La méthode statique `fromGlobals()` de la classe `Request` construit un objet de type `Request` à partir des variables superglobales (en particulier `$_GET`).
