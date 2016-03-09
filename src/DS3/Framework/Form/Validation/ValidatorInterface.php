<?php

namespace DS3\Framework\Form\Validation;

interface ValidatorInterface
{
    /**
     * @param $value mixed The value to validate
     */
    public function validate($value);

    public function setValidationContext(ValidationContext $context);
}
