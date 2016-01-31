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
use DS3\Framework\HTTP\JsonHandler;

$logger = new Logger(new File(__DIR__ . '/../app/prod.log'));
$logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)), true);

try {
    $request = Request::fromGlobals();
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

    $response = new Response(JsonHandler::encode($data));
    $response->send();
    $logger->done();
} catch (\Exception $e) {
    $logger->message(
        sprintf(
            '[%s] : %s',
            date(DATE_ATOM),
            JsonHandler::encode($e)
        )
    );

    $response = new Response(json_encode(array(
        'code' => 500,
        'message' => 'Internal Server Error'
    )), 500);

    $response->send();
    $logger->done();
}