<?php

namespace DS3\Framework\Form\Validation\Violation;

class KeyViolation extends Violation
{
    const TYPE = 'key';

    /**
     * KeyViolation constructor.
     *
     * @param string $field
     * @param string $code
     * @param string $message
     */
    public function __construct($field, $code, $message)
    {
        parent::__construct(self::TYPE, $field, $code, $message);
    }
}