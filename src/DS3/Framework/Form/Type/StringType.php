<?php

namespace DS3\Framework\Form\Type;

class StringType implements TypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function transform($value)
    {
        if ($value === null)
            return null;
        return (string)$value;
    }
}