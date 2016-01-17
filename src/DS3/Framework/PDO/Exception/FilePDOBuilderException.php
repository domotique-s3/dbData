<?php

namespace DS3\Framework\PDO\Exception;

class FilePDOBuilderException extends \Exception
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
