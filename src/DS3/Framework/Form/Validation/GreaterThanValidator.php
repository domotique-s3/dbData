<?php

namespace DS3\Framework\Form\Validation;

class GreaterThanValidator extends AbstractValidator
{
    private static $message = 'This field is not greater than %s';
    private static $code = 'V00003';

    private $comparative;

    /**
     * GreaterThan constructor.
     *
     * @param $comparative mixed value to compare to
     */
    public function __construct($comparative)
    {
        $this->comparative = $comparative;
    }

    public function validate($value)
    {
        if ($value === null) {
            return;
        }
        if (!($value > $this->comparative)) {
            $this->context->add(self::$code, sprintf(self::$message, $this->comparative));
        }
    }
}
