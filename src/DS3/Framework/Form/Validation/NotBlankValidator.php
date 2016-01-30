<?php

namespace DS3\Framework\Form\Validation;

class NotBlankValidator extends AbstractValidator
{
    private static $message = 'This field should not be blank';
    private static $code = 'V00002';

    public function validate($value)
    {
        if ($value === null)
            return;
        if (is_string($value) && trim($value) == '')
            $this->context->add(self::$code, self::$message);
    }
}