<?php

namespace DS3\Framework\Form\Validation;

class SQLFieldValidator implements ValidatorInterface
{
    /**
     * @param $value
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value)
    {
        if (preg_match('/[^a-zA-Z0-9_]+/', $value))
            return 'This field contains an invalid SQL field name';
        return null;
    }
}