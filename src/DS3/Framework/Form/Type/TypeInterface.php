<?php

namespace DS3\Framework\Form\Type;

interface TypeInterface
{
    /**
     * @param $value string
     * @return mixed
     */
    public function transform($value);
}