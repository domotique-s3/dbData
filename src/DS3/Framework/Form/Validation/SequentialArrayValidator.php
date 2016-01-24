<?php

namespace DS3\Framework\Form\Validation;

class SequentialArrayValidator implements ValidatorInterface
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
        return (new AssociativeArrayValidator(array(), $this->validators))->validate($value);
    }
}