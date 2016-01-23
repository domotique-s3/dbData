<?php

namespace DS3\Framework\Form\Validation;


class AssociativeArray implements ValidatorInterface
{
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
     * @return null|string Null if no errors occured, a message if a validation
     * violation was encountered
     */
    public function validate($value)
    {
        if ($value === null)
            return null;
        if (!is_array($value))
            return 'This field should be an array';

        $errors = array();
        foreach ($value as $key => $item) {
            // List key errors
            $keysError = array();
            foreach ($this->keysValidators as $keysValidator) {
                $message = $keysValidator->validate($key);
                if ($message !== null)
                    $keysError[] = $message;
            }
            if (count($keysError) > 0)
                $errors[$key]['$key'] = $keysError;

            // List values errors
            $valuesError = array();
            foreach ($this->valuesValidators as $valuesValidator) {
                $message = $valuesValidator->validate($item);
                if ($message !== null)
                    $valuesError[] = $message;
            }

            if (count($valuesError) > 0)
                $errors[$key]['$value'] = $valuesError;

        }

        return (count($errors) > 0) ? $errors : null;
    }
}