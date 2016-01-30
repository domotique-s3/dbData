<?php

namespace DS3\Framework\Form\Validation;

class SequentialArrayValidator extends AbstractValidator
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    /**
     * All constructor.
     * @param ValidatorInterface[] $validators
     */
    public function __construct(array $validators = array())
    {
        $this->validators = $validators;
    }

    /**
     * @param $value
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value)
    {
        $v = new AssociativeArrayValidator(array(), $this->validators);
        $v->setValidationContext($this->context);
        $v->validate($value);
    }
}