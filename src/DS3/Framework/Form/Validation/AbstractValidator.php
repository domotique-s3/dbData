<?php

namespace DS3\Framework\Form\Validation;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var ValidationContext
     */
    protected $context;

    public function setValidationContext(ValidationContext $context)
    {
        $this->context = $context;
    }
}
