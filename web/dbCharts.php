<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\URLQuery;
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Application\Query\QueryHandler;
use DS3\Framework\HTTP\Response;


// --------------------------------

$request = Request::fromGlobals();
$query = URLQuery::fromRequest($request);

$pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');
$queryHandler = new QueryHandler($pdo_config->getPDO());
$data = $queryHandler->execute($query);

$response = new Response($data);
$response->send();
