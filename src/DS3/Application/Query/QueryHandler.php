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
    private static $_tableCol = 'tablename';
    private static $_sensorIdCol = 'sensor';
    private static $_valuesCol = 'value';
    private static $_timestampCol = 'timestamp';
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
    public function __construct(\PDO $pdo)
    {
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
                if (!isset($rawMeasurment[self::$_valuesCol])) {
                    throw new \InvalidArgumentException(self::$_valuesCol . ' field is missing');
                }

                if (!isset($rawMeasurment[self::$_timestampCol])) {
                    throw new \InvalidArgumentException(self::$_timestampCol . ' field is missing');
                }

                $measurments[] = new Measurment($rawMeasurment[self::$_valuesCol], $rawMeasurment[self::$_timestampCol]);
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
        $res = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $res = $this->groupTwoColumns($res);

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
        $subQueries = array();
        foreach ($query->getTables() as $table)
            $subQueries[] = '(' . $this->buildSubQuery($table, $query) . ')';

        $sql = sprintf(
            "SELECT %s, %s, %s, %s FROM (",
            self::$_tableCol,
            self::$_sensorIdCol,
            self::$_timestampCol,
            self::$_valuesCol
        );

        $sql .= implode(' UNION ALL ', $subQueries);
        $sql .= sprintf(
            ") t ORDER BY
            t.%s ASC,
            t.%s ASC,
            t.%s ASC",
            self::$_tableCol,
            self::$_sensorIdCol,
            self::$_timestampCol
        );

        $sql = preg_replace('/\r\n|\r|\n/', ' ', $sql);
        $sql = preg_replace('/\s+/', ' ', $sql);

        $sth = $this->pdo->prepare($sql);
        if ($this->logger != null)
            $this->logger->message($sql);

        foreach ($query->getTables() as $table)
            foreach ($query->getSensorsByTable($table) as $i => $sensor)
                $sth->bindValue(":$table$i", $sensor);

        if ($query->getStart() !== null)
            $sth->bindValue(':start', $query->getStart());
        if ($query->getEnd() !== null)
            $sth->bindValue(':end', $query->getEnd());

        return $sth;
    }

    private function buildSubQuery($table, Query $query)
    {
        $table = $this->sanitize($table);
        $sensorIdColumn = $this->sanitize($query->getSensorIdColumn());
        $valuesColumn = $this->sanitize($query->getValuesColumn());
        $timestampColumn = $this->sanitize($query->getTimestampColumn());

        $sql = sprintf(
            "SELECT
                CAST('$table' AS TEXT) AS %s,
                $sensorIdColumn AS %s,
                $valuesColumn AS %s,
                $timestampColumn AS %s
            FROM $table",
            self::$_tableCol,
            self::$_sensorIdCol,
            self::$_valuesCol,
            self::$_timestampCol
        );

        $where = array();

        if ($query->getStart() !== null && $query->getEnd() !== null) {
            if ($query->getStart() !== null)
                $where[] = "$timestampColumn > :start";
            if ($query->getEnd() !== null)
                $where[] = "$timestampColumn < :end";
        }

        if (count($sensors = $query->getSensorsByTable($table)) > 0)
            foreach ($sensors as $i => $sensor) {
                $where[] = "$sensorIdColumn = :$table$i";
            }

        if (count($where) > 0) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return $sql;
    }

    protected function sanitize($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }

    /**
     * Groups an array with its two first columns
     * @param array $data
     * @return array
     */
    private function groupTwoColumns(array $data)
    {
        $newResult = array();
        foreach ($data as $row) {
            $newResult[$row[self::$_tableCol]][$row[self::$_sensorIdCol]][] = array(
                self::$_timestampCol => (double)$row[self::$_timestampCol],
                self::$_valuesCol => $row[self::$_valuesCol],
            );
        }

        return $newResult;
    }
}
