<?php

namespace DS3\Application;

/**
 * Database Configuration.
 */
abstract class PDOBuilder
{
    /* --- ATTRIBUTES --- */

    protected $login;
    protected $passwd;
    protected $database_name;
    protected $host;
    protected $connector;

    /* --- METHODS --- */

    /*!
     * Returns user's login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /* --- GETTERS --- */

    /*!
     * Returns user's password
     */
    public function getPassword()
    {
        return $this->passwd;
    }

    /*!
     * Returns database's name
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getConnector()
    {
        return $this->connector;
    }

    /*!
     * Returns PDO
     */
    abstract public function getPDO();
}
