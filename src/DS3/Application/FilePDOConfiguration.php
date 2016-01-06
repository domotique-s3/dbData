<?php

/**
 * Université Paris 13 - Domotique S3
 *
 * PHP 5
 *
 * @author     William Tahar 'Foscor' <william.tahar@gmail.com>
 * @version    1.0
**/

require_once "PDOConfiguration.php";

namespace DS3\Application;

class FilePDOConfiguration extends PDOConfiguration
{   
    const _DB_NAME = 0;
    const _DB_HOST = 1;
    const _DB_CONNECT = 2;
    const _DB_LOGIN = 3
    const _DB_PASSWORD = 4;

    /* File path */
    private $_file;
    /* SGBD String */
    private $_sgbd;   

    /* Database info */
    private $_database_name;
    private $_host;
    private $_connector;
    private $_passwd;


    /**
	*	Constructor FilePDOConfiguration
	*
	* 	@param String $path	File with connection data
	*	@param String $sgbd	Sgbd type	
	*/
    public function __construct($path, $sgbd)
    {
        if (empty($sgbd) or empty($path) or (file_exists($path) == false))
            throw new Exception("Error : No file in parameter", 1);        
        $this->_file = $path;
        $this->_sgbd = $sgbd;
    }

    /** 
	*	@return PDO Object
	*/
    public function getPDO()
    {
        try {
    
            if (($handel = fopen($this->_file, "r")) == false)
                throw new Exception("Error : ".$this->_file." can't be open", 1);

            
            for ($i = 0, ($data = readdir($handel)) != false, $i++)
            {
                switch ($i) {
                    case self::_DB_NAME:
                        $this->_database_name = $data;
                        break;
                    case self::_DB_HOST:
                        $this->_host = $data;
                        break;
                    case self::_DB_CONNECT:
                        $this->_connector = $data;
                        break;
                    case self::_DB_LOGIN:
                        $this->_login = $data;
                        break;
                    case self::_DB_PASSWORD:
                        $this->_passwd = $data;
                        break;                    
                }
                echo $data."\n";
            }
                
            fclose($handel);

         } catch (Exception $e) {
            return (null);
        }

        return getSgbdPDO();
    }

	/** 
	* @return PDO Object
	*/
    public function getSgbdPDO()
    {
        if ($this->_sgbd == 'mysql')
            return new PDO('mysql:host='.$this->_host.';dbname='.$this->_database_name, $this->_login, $this->_passwd);
        
        elseif ($this->_sgbd == 'pgsql')
            return new PDO('pgsql:dbname='.$this->_database_name.' host='.$this->_host, $this->_login, $this->_passwd);
        else
            return null;
    }
	
    /** 
	* @return string	database name
	*/
    public function getDBname()
    {
        return $this->_database_name;
    }
	
    /** 
	* @return string	host name
	*/
    public function getHost()
    {
        return $this->_host;
    }

    /** 
	* @return string	connector
	*/
	public function getConnector()
    {
        return $this->_connector;
    }

	/** 
	* @return string	login
	*/
    public function getLogin()
    {
        return $this->_login;
    }

    /** 
	* @return string	sgbd
	*/
	public function getSgbd()
    {
       return $this->_sgbd;
    }

    /** 
	*	@param string	sgbd
	*/
    public function setSgbd($sgbd)
    {
        $this->_sgbd = $sgbd;
    }
}

?>
