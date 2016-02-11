<?php

namespace DS3\Application;

use DS3\Framework\HTTP\Request;
use DS3\Application\Query\Query;
use DS3\Application\Query\QueryHandler;
use DS3\Application\Query\QueryFormBuilder;
use DS3\Framework\HTTP\JsonResponse;
use DS3\Framework\PDO\PDOBuilder;
use DS3\Framework\Logger\Logger;
use DS3\Framework\Logger\LoggerAwareInterface;

class Controller implements LoggerAwareInterface
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
     * @param Logger     $logger
     */
    public function __construct(PDOBuilder $pdoBuilder, Logger $logger)
    {
        $this->pdoBuilder = $pdoBuilder;
        $this->setLogger($logger);
    }

    public function handle(Request $request)
    {
        $this->logger->message("Creating query");
        $query = new Query();
        $this->logger->message("Creating form");
        try {
            $form = (new QueryFormBuilder())->buildForm($query);
        } catch (\Exception $e) {
            throw new \Exception("Cannot build form", 0, $e);
        }

        $this->logger->message("Submitting request to form");
        try {
            $form->submit($request->getQuery()->all());
        } catch (\Exception $e) {
            throw new \Exception("Cannot submit request to form", 0, $e);
        }

        if ($form->isValid()) {
            $this->logger->message("The form is valid");
            $this->logger->message("Creating query handler");
 
            try {
                $queryHandler = new QueryHandler($this->pdoBuilder->getPDO());
            } catch (\Exception $e) {
                throw new \Exception("Cannot create query handler", 0, $e);
            }

            $queryHandler->setLogger($this->logger);

            $this->logger->message("Executing query");
            $data = $queryHandler->execute($query);

            try {
                return new JsonResponse($data, 200);
            } catch (\Exception $e) {
                throw new \Exception("Cannot create response", 0, $e);
            }
        }

        $this->logger->message("The form is not valid");

        try {
            return new JsonResponse($form->getErrors(), 400);
        } catch (\Exception $e) {
            throw new \Exception("Cannot create response", 0, $e);
        }
    }

    public function setLogger(Logger $logger = null) {
        $this->logger = $logger;
    }
}
