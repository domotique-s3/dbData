<?php

namespace DS3\Framework\Form\Validation;

class SQLFieldValidator extends AbstractValidator
{
    private static $message = 'This field contains an invalid SQL field name';
    private static $code = 'V00010';

    public function validate($value)
    {
        if (preg_match('/[^a-zA-Z0-9_]+/', $value))
            $this->context->add(self::$code, self::$message);
    }
}