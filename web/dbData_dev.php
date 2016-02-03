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
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Framework\HTTP\Response;
use DS3\Framework\Logger\Logger;
use DS3\Framework\Filesystem\File;
use DS3\Framework\HTTP\JsonHandler;

$logger = new Logger(new File(__DIR__ . '/../app/dev.log'));
$logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)), true);

try {
    $request = Request::fromGlobals();
    $logger->message('Handling request ' .
        "`{$request->getMethod()} $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]`");

    $pdo_config = new FilePDOBuilder(__DIR__ . '/../app/pdo.cfg');

    $controller = new \DS3\Application\Controller($pdo_config, $logger);
    $response = $controller->handle($request);
    $response->send();
    $logger->done();
} catch (\Exception $e) {
    $json = JsonHandler::encode($e);
    $logger->message($json);
    $logger->done();

    $response = new Response($json, 500);
    $response->send();
}