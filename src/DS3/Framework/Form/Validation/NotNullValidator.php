<?php

namespace DS3\Framework\Form\Validation;

class NotNullValidator extends AbstractValidator
{
    private static $message = 'This field should not be null';
    private static $code = 'V00001';

    /**
     * @param $value
     *
     * @return null|string Null if no errors occured, a message if a validation
     *                     violation was encountered
     */
    public function validate($value)
    {
        if ($value === null) {
            $this->context->add(self::$code, self::$message);
        }
    }
}
