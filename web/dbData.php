<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DS3\Framework\HTTP\Request;
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Framework\HTTP\JsonResponse;
use DS3\Framework\Logger\Logger;
use DS3\Framework\Filesystem\File;
use DS3\Framework\HTTP\JsonHandler;

$logger = new Logger(new File(__DIR__ . '/../app/prod.log'));
$logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)), true);

try {
    $request = Request::fromGlobals();
    $pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');
    $controller = new \DS3\Application\Controller($pdo_config, $logger);
    $response = $controller->handle($request);
    $response->send();
    $logger->done();
} catch (\Exception $e) {
    $logger->message(
        sprintf(
            'Exception occured : %s',
            JsonHandler::encode($e)
        )
    );

    $response = new JsonResponse(array(
        'code' => 500,
        'message' => 'Internal Server Error'
    ), 500);

    $response->send();
    $logger->done();
}
