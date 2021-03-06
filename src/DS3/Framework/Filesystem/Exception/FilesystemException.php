<?php

namespace DS3\Framework\Filesystem\Exception;

class FilesystemException extends \RuntimeException
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
