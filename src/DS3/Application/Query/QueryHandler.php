<?php

namespace DS3\Application\Query;

use DS3\Framework\Logger\Logger;
use DS3\Framework\Logger\LoggerAwareInterface;

/**
 * Handles a query with a given PDO connection.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class QueryHandler implements LoggerAwareInterface
{
    private static $sensorCol = 'sensor';
    private static $valuesCol = 'value';
    private static $timestampCol = 'timestamp';

    /**
     * @var Logger|null
     */
    protected $logger;
    /**
     * @var \PDO The PDO connection object.
     */
    private $pdo;

    /**
     * Constructs a QueryHandler with a PDO connection.
     *
     * @param $pdo \PDO The PDO connection object
     */
    public function __construct($pdo)
    {
        if (!$pdo instanceof \PDO)
            throw new \Exception("La variable n'est pas un PDO");

        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param array $output
     *
     * @return Serie[]
     */
    public static function toSeries(array $output)
    {
        $ret = array();
        foreach ($output as $sensorId => $rawMeasurments) {
            if (!is_array($rawMeasurments)) {
                throw new \InvalidArgumentException('Measurments must be an array');
            }

            $measurments = array();
            foreach ($rawMeasurments as $rawMeasurment) {
                if (!isset($rawMeasurment[self::$valuesCol])) {
                    throw new \InvalidArgumentException(self::$valuesCol.' field is missing');
                }

                if (!isset($rawMeasurment[self::$timestampCol])) {
                    throw new \InvalidArgumentException(self::$timestampCol.' field is missing');
                }

                $measurments[] = new Measurment($rawMeasurment[self::$valuesCol], $rawMeasurment[self::$timestampCol]);
            }

            $ret[] = new Serie($sensorId, $measurments);
        }

        return $ret;
    }

    /**
     * Injects the logger.
     *
     * @param Logger|null $logger The logger to inject
     */
    public function setLogger(Logger $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * Executes a given Query to the inner PDO connection.
     */
    public function execute(Query $query)
    {
        $statement = $this->prepareSQL($query);

        if ($this->logger != null) {
            $this->logger->message('QueryHandler : executing query ...', true);
        }

        $statement->execute();
        $res = $statement->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_ASSOC);

        if ($this->logger != null) {
            $this->logger->done();
        }

        return $res;
    }

    /**
     * @param Query $query
     *
     * @return \PDOStatement
     */
    private function prepareSQL(Query $query)
    {
        // Securing variables names, as PDO can't escape table and column names
        $timestampCol = $this->sanitize($query->getTimestampColumn());
        $sensorCol = $this->sanitize($query->getSensorColumn());
        $valuesCol = $this->sanitize($query->getValuesColumn());
        $table = $this->sanitize($query->getTable());
        $start = $query->getStartTime();
        $end = $query->getEndTime();

        $sql = "SELECT
            $sensorCol AS ".self::$sensorCol.",
            $timestampCol AS ".self::$timestampCol.",
            $valuesCol AS ".self::$valuesCol."
          FROM $table";

        $whereClauses = array();
        $params = array();

        // sensorId IN ...
        $sensorIds = $query->getSensorIds();
        $cnt = count($sensorIds);
        if ($cnt != 0) {
            $whereIn = "$sensorCol IN (";

            foreach ($sensorIds as $i => $id) {
                $whereIn .= ":sensor$i";
                if ($i < $cnt - 1) {
                    $whereIn .= ', ';
                }
                $params[] = array(":sensor$i", $id, \PDO::PARAM_STR);
            }

            $whereIn .= ')';
            $whereClauses[] = $whereIn;
        }

        // timestamp > $start
        if ($start != null) {
            $whereClauses[] = "$timestampCol > :start";
            $params[] = array(':start', $start, \PDO::PARAM_INT);
        }

        // timestamp < $end
        if ($end != null) {
            $whereClauses[] = "$timestampCol < :end";
            $params[] = array(':end', $end, \PDO::PARAM_INT);
        }

        // Building the WHERE clause
        if (($cnt = count($whereClauses)) > 0) {
            $sql .= ' WHERE ';
            for ($i = 0; $i < $cnt; ++$i) {
                if ($i != 0) {
                    $sql .= ' AND ';
                }
                $sql .= "{$whereClauses[$i]}";
            }
        }

        $sql .= " ORDER BY $timestampCol ASC;";

        // Preparing the SQL
        $statement = $this->pdo->prepare($sql);
        foreach ($params as $args) {
            call_user_func_array(array($statement, 'bindValue'), $args);
        }

        if ($this->logger != null) {
            $this->logger->message("QueryHandler : $sql with params ".json_encode($params));
        }

        return $statement;
    }

    protected function sanitize($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }
}
