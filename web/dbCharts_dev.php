<?php

if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', 'fe80::1', '::1']) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check ' . basename(__FILE__) . ' for more information.');
}

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

$logger = new Logger(new File(__DIR__ . '/../app/dev.log'));
$logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)), true);

try {

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

    $response = new Response(JsonHandler::encode($data));
    $response->send();
} catch (\Exception $e) {
    $json = JsonHandler::encode($e);
    $logger->message($json);
    $logger->done();

    $response = new Response($json, 500);
    $response->send();
}