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
    private const _DB_NAME = 0;
    private const _DB_HOST = 1;
    private const _DB_CONNECT = 2;
    private const _DB_LOGIN = 3
    private const _DB_PASSWORD = 4;

    // File path
    private $_file;
    // SGBD String
    private $_sgbd;   

    // Database info
    private $_database_name;
    private $_host;
    private $_connector;
    private $_passwd;


    // Constructor 
    public function __construct($path, $sgbd)
    {
        if (empty($sgbd) or empty($path) or (file_exists($path) == false))
            throw new Exception("Error : No file in parameter", 1);        
        $_file = $path;
        $_sgbd = $sgbd;
    }

    // Return PDO Object
    public function getPDO()
    {
        try {
    
            if (($handel = fopen($_file, "r")) == false)
                throw new Exception("Error : $_file can't be open", 1);

            
            for ($i = 0, ($data = readdir($handel)) != false, $i++)
            {
                switch ($i) {
                    case _DB_NAME:
                        $_database_name = $data;
                        break;
                    case _DB_HOST:
                        $_host = $data;
                        break;
                    case _DB_CONNECT:
                        $_connector = $data;
                        break;
                    case _DB_LOGIN:
                        $_login = $data;
                        break;
                    case _DB_PASSWORD:
                        $_passwd = $data;
                        break;                    
                }
                echo $data."\n";
            }
                
            fclose($handel);

         } catch (Exception $e) {
            return (null);
        }

        if ($_sgbd == 'mysql')
            return new PDO('mysql:host='.$_host.';dbname='.$_database_name, $_login, $_passwd);
        
        elseif ($_sgbd == 'pgsql')
            return new PDO('pgsql:dbname='.$_database_name.' host='.$_host, $_login, $_passwd);
    }

    // Get functions
    public function getDBname()
    {
        return $_database_name;
    }

    public function getHost()
    {
        return $_host;
    }

    public function getConnector()
    {
        return $_connector;
    }

    public function getLogin()
    {
        return $_login;
    }

    public function getSgbd()
    {
       return $_sgbd;
    }

    // Set function
    public function setSgbd($sgbd)
    {
        $_sgbd = $sgbd;
    }
}

?>
