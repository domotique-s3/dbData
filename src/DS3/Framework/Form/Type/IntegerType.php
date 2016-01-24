<?php

namespace DS3\Framework\Form\Type;

class IntegerType implements TypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function transform($value)
    {
        return (int)$value;
    }
}