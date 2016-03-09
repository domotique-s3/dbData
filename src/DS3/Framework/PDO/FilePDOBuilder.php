<?php

namespace DS3\Framework\PDO;

use DS3\Framework\Filesystem\File;
use DS3\Framework\PDO\Exception\FilePDOBuilderException;

/**
 * PDO builder from configuration file.
 *
 * @author Sébastien Klasa <skeggib@gmail.com>
 */
class FilePDOBuilder extends PDOBuilder
{
    /**
     * Configuration file.
     *
     * @var File
     */
    private $file;

    /**
     * Open and read a configuration file.
     *
     * @param string $path Path to the configuration file
     */
    public function __construct($path)
    {
        if (!File::exists($path)) {
            throw new FilePDOBuilderException('Configuration file does not exists');
        }

        $this->file = new File($path);
        $str = $this->file->read();

        $array = explode("\n", $str);

        if (count($array) < 5) {
            throw new FilePDOBuilderException('Configuration file does not contains all required informations');
        }

        $this->setDriver($array[0]);
        $this->setDatabaseName($array[1]);
        $this->setHost($array[2]);
        $this->setUsername($array[3]);
        $this->setPassword($array[4]);
    }
}
