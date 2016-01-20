<?php

namespace DS3\Framework\Form\Type;

class StringType implements TypeInterface
{
    /**
     * @param $value string
     * @return mixed
     */
    public function transform($value)
    {
        return (string)$value;
    }
}