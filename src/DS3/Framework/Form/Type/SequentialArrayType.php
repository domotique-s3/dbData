<?php

namespace DS3\Framework\Form\Type;

class SequentialArrayType implements TypeInterface
{
    /**
     * @var TypeInterface
     */
    private $valuesType;

    /**
     * SequentialArrayType constructor.
     *
     * @param TypeInterface $valuesType
     */
    public function __construct(TypeInterface $valuesType)
    {
        $this->valuesType = $valuesType;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function transform($value)
    {
        return (new AssociativeArrayType(new IntegerType(), $this->valuesType))
            ->transform($value);
    }
}
