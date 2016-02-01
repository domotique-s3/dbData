<?php

namespace DS3\Framework\Form\Type;

class DoubleType implements TypeInterface
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function transform($value)
    {
        if ($value === null) {
            return;
        }

        return (double) $value;
    }
}
