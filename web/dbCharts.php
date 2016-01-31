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

$logger = new Logger(new File(__DIR__ . '/../app/dev.log'));
$logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)), true);

$request = Request::fromGlobals();
$logger->message('Handling request ' .
    "`{$request->getMethod()} $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]`");

$query = new Query();
$form = (new QueryFormBuilder())->buildForm($query);

$form->submit($request->getQuery()->all());

if ($form->isValid()) {
    $pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');
    $queryHandler = new QueryHandler($pdo_config->getPDO());
    $queryHandler->setLogger($logger);
    $data = $queryHandler->execute($query);
} else {
    $data = $form->getErrors();
}

$response = new Response(json_encode($data));
$response->send();

$logger->done();