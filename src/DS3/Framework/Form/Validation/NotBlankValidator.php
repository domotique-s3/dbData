<?php

namespace DS3\Framework\Form\Validation;

class NotBlankValidator implements ValidatorInterface
{
    /**
     * @param $value
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value)
    {
        if ($value === null)
            return null;
        if (is_string($value) && trim($value) == '')
            return 'This field should not be blank';
        return null;
    }
}