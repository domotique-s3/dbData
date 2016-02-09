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

try {
    $logger->message("-------------------------------------------------------\n");
    $logger->message(sprintf('[%s] : Started dbCharts', date(DATE_ATOM)));

    // --- Request

    $logger->message("Creating request...", true);
    $request = Request::fromGlobals();
    $logger->done();

    $logger->message('Handling request ' .
    "`{$request->getMethod()} $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]`");

    // --- PDO configuration

    $pdo_cfg_path = '/../app/pdo.cfg';
    $logger->message("Loading PDO configuration from file '" . $pdo_cfg_path . "'...", true);
    $pdo_config = new FilePDOBuilder(__DIR__ . $pdo_cfg_path);
    $logger->done();

    // --- Controller

    $logger->message("Creating controller...", true);
    $controller = new \DS3\Application\Controller($pdo_config, $logger);
    $logger->done();

    // --- Response

    $logger->message("Creating response...", true);
    try {
        $response = $controller->handle($request);
    } catch (\Exception $e) {
        throw new \Exception("Cannot handle request", 0, $e);
    }
    $logger->done();

    $logger->message("Sending response", false);
    $response->send();
    
} catch (\Exception $e) {
    $json = JsonHandler::encode($e);
    $logger->message($e);

    $response = new Response($json, 500);
    $response->send();
}