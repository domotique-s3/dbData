<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\Query;
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Application\Query\QueryHandler;
use DS3\Framework\HTTP\Response;
use DS3\Framework\Logger\Logger;
use DS3\Framework\Filesystem\File;
use DS3\Application\Query\QueryFormBuilder;


// --------------------------------

$request = Request::fromGlobals();
$query = new Query();
$form = (new QueryFormBuilder())->buildForm($query);
$form->submit($request->getQuery()->all());

if ($form->isValid()) {
    $logger = new Logger(new File(__DIR__ . '/../app/dev.log'));
    $pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');
    $queryHandler = new QueryHandler($pdo_config->getPDO());
    $queryHandler->setLogger($logger);
    $data = $queryHandler->execute($query);
} else {
    $data = $form->getErrors();
}

$response = new Response(json_encode($data));
$response->send();
