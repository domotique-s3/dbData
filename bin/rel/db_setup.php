<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use DS3\Framework\Filesystem\File;

function readline_m($prompt = null){
    if (function_exists("readline")) {
        $line = readline();
        return $line;
    } else {
        if($prompt){
            echo $prompt;
        }
        $fp = fopen("php://stdin","r");
        $line = rtrim(fgets($fp, 1024));
        return $line;
    }
}

$file = new File('app/pdo.cfg');

echo "--- DBCHARTS SETUP --- \n\n";
echo "You will be asked to enter your EXISTING database configuration.\n\n";

/* DBSM */

$dbsm = null;
$availables_dbsm = array(
    'pgsql' => 'Postgresql',
    'mysql' => 'MySQL',
);
$dbsm_keys = array_keys($availables_dbsm);

while ($dbsm == null) {
    echo "\nPlease chose your DBMS :\n\n";
    for ($i = 0; $i < count($dbsm_keys); ++$i) {
        print($i + 1).'. '.$availables_dbsm[$dbsm_keys[$i]]."\n";
    }

    $answer = readline_m();
    if (is_numeric($answer)) {
        if ($answer > 0 && $answer <= count($dbsm_keys)) {
            $dbsm = $dbsm_keys[$answer - 1];
        }
    }
}

/* Database name */

echo "\nEnter the database name : ";
$db_name = readline_m();

/* Host */

echo "\nEnter the database hostname (default=localhost) : ";
$host = readline_m();
if ($host === '') {
    $host = 'localhost';
}

/* Login */

echo "\nEnter the database login : ";
$login = readline_m();

/* Password */

echo "\nEnter the database password : ";
$passwd = readline_m();

/* Write */

$file->clear();
$file->write($dbsm."\n".$db_name."\n".$host."\n".$login."\n".$passwd."\n");
