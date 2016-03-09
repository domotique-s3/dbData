<?php

namespace DS3\Framework\Form;

use DS3\Framework\Form\Type\TypeInterface;
use DS3\Framework\Form\Validation\ValidatorInterface;

class Field
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * Field constructor.
     *
     * @param string               $name
     * @param ValidatorInterface[] $validators
     * @param TypeInterface        $transformer
     */
    public function __construct($name, array $validators, TypeInterface $transformer)
    {
        if ($name == null) {
            throw new \InvalidArgumentException('Name can not be null');
        }

        $this->name = (string) $name;
        $this->validators = array();
        $this->type = $transformer;

        foreach ($validators as $validator) {
            if (!($validator instanceof ValidatorInterface)) {
                throw new \InvalidArgumentException('Validators should implement ValidatorInterface');
            }

            $this->validators[] = $validator;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ValidatorInterface[]
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }
}
