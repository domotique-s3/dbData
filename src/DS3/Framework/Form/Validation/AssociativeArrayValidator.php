<?php

namespace DS3\Framework\Form\Validation;

class AssociativeArrayValidator extends AbstractValidator
{
    private static $message = 'This field should be an array';
    private static $code = 'V00004';

    /**
     * @var ValidatorInterface[]
     */
    private $keysValidators;

    /**
     * @var ValidatorInterface[]
     */
    private $valuesValidators;

    /**
     * AssociativeArray constructor.
     *
     * @param ValidatorInterface[] $keysValidators
     * @param ValidatorInterface[] $valuesValidators
     */
    public function __construct(array $keysValidators = array(), array $valuesValidators = array())
    {
        $this->keysValidators = $keysValidators;
        $this->valuesValidators = $valuesValidators;
    }

    /**
     * @param $value
     *
     * @return null|string Null if no errors occured, a message if a validation
     *                     violation was encountered
     */
    public function validate($value)
    {
        if ($value === null) {
            return;
        }
        if (!is_array($value)) {
            $this->context->add(self::$code, self::$message);

            return;
        }

        foreach ($value as $key => $item) {
            foreach ($this->keysValidators as $keysValidator) {
                $subContextKey = $this->context->createSubContext($key, 'key');
                $keysValidator->setValidationContext($subContextKey);
                $keysValidator->validate($key);
            }

            foreach ($this->valuesValidators as $valuesValidator) {
                $subContextValue = $this->context->createSubContext($key);
                $valuesValidator->setValidationContext($subContextValue);
                $valuesValidator->validate($item);
            }
        }
    }
}
