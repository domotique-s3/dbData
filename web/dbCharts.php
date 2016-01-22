<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\Query;
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Application\Query\QueryHandler;
use DS3\Framework\HTTP\Response;
use DS3\Framework\Logger\Logger;
use DS3\Framework\Filesystem\File;


// --------------------------------

$request = Request::fromGlobals();
$query = new Query();
$query->setSensorIdColumn('sensor_id');
$query->setTimestampColumn('timestamp');
$query->setValuesColumn('value');
$query->setSensors(array(
    'measurments' => array(1)
));
$query->setStart(1417962686);
$query->setEnd($query->getStart() + 1000);

$logger = new Logger(new File(__DIR__ . '/../app/dev.log'));
$pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');
$queryHandler = new QueryHandler($pdo_config->getPDO());
$queryHandler->setLogger($logger);
$data = $queryHandler->execute($query);

/*
$response = new Response($data);
$response->send();
*/