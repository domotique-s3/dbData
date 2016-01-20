<?php

namespace DS3\Framework\Form\Validation;

interface ValidatorInterface
{
    /**
     * @param $value
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value);
}