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
    /**
     * @var Logger|null
     */
    protected $logger;
    private $_tableCol = 'tablename';
    private $_sensorIdCol = 'sensor';
    private $_valuesCol = 'value';
    private $_timestampCol = 'timestamp';
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
    public function toSeries(array $output)
    {
        $ret = array();
        foreach ($output as $sensorId => $rawMeasurments) {
            if (!is_array($rawMeasurments)) {
                throw new \InvalidArgumentException('Measurments must be an array');
            }

            $measurments = array();
            foreach ($rawMeasurments as $rawMeasurment) {
                if (!isset($rawMeasurment[$this->_valuesCol])) {
                    throw new \InvalidArgumentException($this->_valuesCol . ' field is missing');
                }

                if (!isset($rawMeasurment[$this->_timestampCol])) {
                    throw new \InvalidArgumentException($this->_timestampCol . ' field is missing');
                }

                $measurments[] = new Measurment($rawMeasurment[$this->_valuesCol], $rawMeasurment[$this->_timestampCol]);
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

        $sql = "SELECT
            {$this->_tableCol},
            {$this->_sensorIdCol},
            {$this->_timestampCol},
            {$this->_valuesCol} FROM (";

        $sql .= implode(' UNION ALL ', $subQueries);
        $sql .= ") t ORDER BY
            t.{$this->_tableCol} ASC,
            t.{$this->_sensorIdCol} ASC,
            t.{$this->_timestampCol} ASC";

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

        $sql =
            "SELECT
                CAST('$table' AS TEXT) AS {$this->_tableCol},
                $sensorIdColumn AS {$this->_sensorIdCol},
                $valuesColumn AS {$this->_valuesCol},
                $timestampColumn AS {$this->_timestampCol}
            FROM $table";

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
            $newResult[$row[$this->_tableCol]][$row[$this->_sensorIdCol]][] = array(
                $this->_timestampCol => $row[$this->_timestampCol],
                $this->_valuesCol => $row[$this->_valuesCol],
            );
        }

        return $newResult;
    }
}
