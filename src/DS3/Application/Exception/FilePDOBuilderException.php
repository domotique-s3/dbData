<?php

namespace DS3\Application\Exception;

use DS3\Framework\Filesystem\File;

class FilePDOBuilderException extends \Exception {

	public function __construct($message = "", $code = 0, \Exception $previous = NULL) {
		parent::__construct($message, $code, $previous);
	}

}