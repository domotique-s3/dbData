<?php

namespace DS3\Application;

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\Query;
use DS3\Application\Query\QueryHandler;
use DS3\Application\Query\QueryFormBuilder;
use DS3\Framework\HTTP\Response;
use DS3\Framework\HTTP\JsonHandler;
use DS3\Framework\Logger\Logger;
use DS3\Framework\PDO\PDOBuilder;

class Controller
{
    /**
     * @var PDOBuilder
     */
    protected $pdoBuilder;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Controller constructor.
     *
     * @param PDOBuilder $pdoBuilder
     * @param Logger $logger
     */
    public function __construct(PDOBuilder $pdoBuilder, Logger $logger)
    {
        $this->pdoBuilder = $pdoBuilder;
        $this->logger = $logger;
    }

    public function handle(Request $request)
    {
        $query = new Query();
        $form = (new QueryFormBuilder())->buildForm($query);

        $form->submit($request->getQuery()->all());

        if ($form->isValid()) {
            $queryHandler = new QueryHandler($this->pdoBuilder->getPDO());
            $queryHandler->setLogger($this->logger);
            $data = $queryHandler->execute($query);
        } else {
            $data = $form->getErrors();
        }

        return new Response(JsonHandler::encode($data));
    }
}
