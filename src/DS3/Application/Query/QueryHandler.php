<?php

namespace DS3\Application\Query;

/**
 * Handles a query with a given PDO connection.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class QueryHandler
{
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
        $this->pdo = $pdo;
    }

    /**
     * Executes a given Query to the inner PDO connection.
     */
    public function execute(Query $query)
    {
        // Securing variables names, as PDO can't escape table and column names
        $timestampCol = $this->sanitize($query->getTimestampColumn());
        $sensorCol = $this->sanitize($query->getSensorColumn());
        $valuesCol = $this->sanitize($query->getValuesColumn());
        $table = $query->getTable();
        $start = $query->getStartTime();
        $end = $query->getEndTime();

        $sql = "SELECT $sensorCol, $timestampCol, $valuesCol FROM $table";

        $whereClauses = array();
        $params = array();

        // sensorId IN ...
        $sensorIds = $query->getSensorIds();
        $cnt = count($sensorIds);
        if ($cnt != 0) {
            $whereIn = "$sensorCol IN (";

            foreach ($sensorIds as $i => $id) {
                $whereIn .= ":sensor$i";
                if ($i < $cnt - 1)
                    $whereIn .= ', ';
                $params[] = array(":sensor$i", $id, \PDO::PARAM_STR);
            }

            $whereIn .= ')';
            $whereClauses[] = $whereIn;
        }

        // timestamp > $start
        if ($start != null) {
            $whereClauses[] = "$timestampCol > :start";
            $params[] = array(':start', $start->getTimestamp(), \PDO::PARAM_INT);
        }

        // timestamp < $end
        if ($end != null) {
            $whereClauses[] = "$timestampCol < :end";
            $params[] = array(':end', $end->getTimestamp(), \PDO::PARAM_INT);
        }

        // Building the WHERE clause
        if (($cnt = count($whereClauses)) > 0) {
            $sql .= " WHERE ";
            for ($i = 0; $i < $cnt; $i++) {
                if ($i != 0)
                    $sql .= " AND ";
                $sql .= "{$whereClauses[$i]}";
            }
        }

        $sql .= " ORDER BY $timestampCol ASC;";

        // Preparing the SQL
        $statement = $this->pdo->prepare($sql);
        foreach ($params as $args) {
            call_user_func_array(array($statement, 'bindValue'), $args);
        }

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_UNIQUE | \PDO::FETCH_ASSOC);
    }

    protected function sanitize($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }
}
