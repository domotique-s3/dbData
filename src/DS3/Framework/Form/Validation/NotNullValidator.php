<?php

namespace DS3\Framework\Form\Validation;

class NotNullValidator implements ValidatorInterface
{
    /**
     * @param $value
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value)
    {
        return ($value === null) ? 'This field should not be null' : null;
    }
}