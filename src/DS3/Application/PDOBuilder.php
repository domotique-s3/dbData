<?php

namespace DS3\Application;

/**
 * Database Configuration.
 */
class PDOBuilder
{

    protected $login;
    protected $passwd;
    protected $database_name;
    protected $host;
    protected $driver;

    public function setLogin($login) {
        $this->login = $login;
    }

    /*!
     * Returns user's login
     */
    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($passwd) {
        $this->passwd = $passwd;
    }

    /*!
     * Returns user's password
     */
    public function getPassword()
    {
        return $this->passwd;
    }

    public function setDatabaseName($database_name) {
        $this->database_name = $database_name;
    }

    /*!
     * Returns database's name
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setDriver($driver) {
        $this->driver = $driver;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    /*!
     * Returns PDO
     */
    public function getPDO() {
        return new \PDO($this->driver.':dbname='.$this->database_name.' host='.$this->host, $this->login, $this->passwd);
    }
}
