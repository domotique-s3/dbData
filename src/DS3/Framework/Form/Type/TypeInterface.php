<?php

namespace DS3\Framework\Form\Type;

interface TypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function transform($value);
}