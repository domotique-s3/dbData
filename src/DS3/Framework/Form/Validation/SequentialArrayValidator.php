<?php

namespace DS3\Framework\Form\Validation;

class SequentialArrayValidator extends AbstractValidator
{
    private static $message = 'This field should be a sequential array';
    private static $code = 'V00005';

    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    /**
     * All constructor.
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(array $validators = array())
    {
        $this->validators = $validators;
    }

    /**
     * @param $value
     *
     * @return null|string Null if no errors occured, a message if a validation
     *                     violation was encountered
     */
    public function validate($value)
    {
        if(is_array($value))
            if(array_keys($value) !== range(0, count($value) - 1)) {
                $this->context->add(self::$code, self::$message);
                return;
            }

        $v = new AssociativeArrayValidator(array(), $this->validators);
        $v->setValidationContext($this->context);
        $v->validate($value);
    }
}
