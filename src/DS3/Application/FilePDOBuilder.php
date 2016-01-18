<?php

namespace DS3\Application;

use DS3\Framework\Filesystem\File;
use DS3\ApplicationFilePDOBuilderException\FilePDOBuilderException;

/**
 * Build a PDO from a configuration file.
 *
 * @author Sébastien Klasa <skeggib@gmail.com>
 */
class FilePDOBuilder extends PDOBuilder {

	private $file;

	/**
	 * Constructor by file path
	 * @param string $path Path of the configuration file
	 */
	public function __construct($path) {
		if (!File::exists($path))
			throw new FilePDOBuilderException("Configuration file does not exists");
		$this->file = new File($path);
		$str = $this->file->read();

		$array = explode("\n", $str);

		if (count($array) < 5)
			throw new FilePDOBuilderException("Configuration file does not contains all required informations");

		$this->driver = $array[0];
		$this->database_name = $array[1];
		$this->host = $array[2];
		$this->login = $array[3];
		$this->passwd = $array[4];
	}

}
