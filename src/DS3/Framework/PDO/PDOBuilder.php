<?php

namespace DS3\Framework\PDO;

/**
 * PDO builder
 *
 * @author Sébastien Klasa <skeggib@gmail.com>
 */
class PDOBuilder
{
    /**
     * @var string The username
     */
    private $username;

    /**
     * @var string The password
     */
    private $password;

    /**
     * @var string The host fot the connection
     */
    private $host;

    /**
     * @var string The name of the database
     */
    private $databaseName;

    /**
     * @var string The name of the driver to use
     */
    private $driver;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return PDOBuilder
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return PDOBuilder
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return PDOBuilder
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @param string $databaseName
     *
     * @return PDOBuilder
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $driver
     *
     * @return PDOBuilder
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Builds the PDO instance.
     *
     * @return \PDO The build instance of PDO
     */
    public function getPDO()
    {
        return new \PDO(
            "{$this->driver}:host={$this->host};dbname={$this->databaseName}",
            $this->username,
            $this->password
        );
    }
}
