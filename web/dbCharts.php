<?php

require_once __DIR__ . "/../vendor/autoload.php";

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\Query;
use DS3\Framework\PDO\FilePDOBuilder;
use DS3\Application\Query\QueryHandler;
use DS3\Framework\HTTP\Response;
use DS3\Framework\Form\Field;
use DS3\Framework\Form\Validation\NotBlank;
use DS3\Framework\Form\Validation\SQLField;
use DS3\Framework\Form\Type\StringType;
use DS3\Framework\Form\Form;

$request = Request::fromGlobals();

$query = new Query();

$form = new Form($query);
$form->add(new Field('table', array(new NotBlank(), new SQLField()), new StringType()));
$form->submit($request->getQuery()->all());

$errors = $form->getErrors();

/*
$pdoBuilder = new FilePDOBuilder(__DIR__.'/../app/pdo.cfg');
$queryHandler = new QueryHandler($pdoBuilder->getPDO());
$data = $queryHandler->execute($query);

$response = new Response($data);
$response->send();
*/