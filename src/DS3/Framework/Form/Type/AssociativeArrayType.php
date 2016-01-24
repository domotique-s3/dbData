<?php

namespace DS3\Framework\Form\Type;

class AssociativeArrayType implements TypeInterface
{
    /**
     * @var TypeInterface
     */
    private $keyType;

    /**
     * @var TypeInterface
     */
    private $valueType;

    /**
     * AssociativeArrayType constructor.
     * @param TypeInterface $keyType
     * @param TypeInterface $valueType
     */
    public function __construct(TypeInterface $keyType, TypeInterface $valueType)
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }


    /**
     * @param $value
     * @return mixed
     */
    public function transform($value)
    {
        if ($value === null)
            return null;

        $res = array();
        foreach ($value as $key => $item) {
            $res[$this->keyType->transform($key)] =
                $this->valueType->transform($item);
        }

        return $res;
    }
}