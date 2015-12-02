<?php

namespace DS3\Application;

/**
 * Database Configuration.
 */
abstract class PDOConfiguration
{
    /* --- ATTRIBUTES --- */

    protected $login;
    protected $passwd;
    protected $database_name;

    /* --- METHODS --- */

    /*!
     * Returns user's login
     */
    public function getLogin()
    {
        return $this->login;
    }

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

    /*!
     * Returns PDO
     */
    abstract public function getPDO();
}
