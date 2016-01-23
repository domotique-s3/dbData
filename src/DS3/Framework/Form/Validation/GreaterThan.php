<?php

namespace DS3\Framework\Form\Validation;

class GreaterThan implements ValidatorInterface
{
    private $comparative;

    /**
     * GreaterThan constructor.
     * @param $comparative mixed value to compare to
     * @param $toString callable|string Stringified representation of comparative
     */
    public function __construct($comparative)
    {
        $this->comparative = $comparative;
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

        if (!($value > $this->comparative))
            return "This field is not greater than {$this->comparative}";
        return null;
    }
}