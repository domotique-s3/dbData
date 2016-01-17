<?php

namespace DS3\Application;

use DS3\Framework\Filesystem\File;

class FilePDOConfiguration extends PDOConfiguration {

	private $file;

	/* --- CONTRUCTOR --- */

	public function __construct($path) {
		if (!File::exists($path))
			throw new exception("Configuration file does not exists");
		$this->file = new File($path);
		$str = $this->file->read();

		if ($str == "")
			throw new \Exception("$path is empty");

		$array = explode("\n", $str);
		$this->connector = $array[0];
		$this->database_name = $array[1];
		$this->host = $array[2];
		$this->login = $array[3];
		$this->passwd = $array[4];
	}

	public function getPDO() {
		switch ($this->connector) {
			case 'pgsql':
				return new \PDO('pgsql:dbname='.$this->database_name.' host='.$this->host, $this->login, $this->passwd);
			break;
			case 'mysql':
				return new \PDO('mysql:host='.$this->host.';dbname='.$this->database_name, $this->login, $this->passwd);
			break;
		}
	}

}