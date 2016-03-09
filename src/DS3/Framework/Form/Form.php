<?php

namespace DS3\Framework\Form;

use DS3\Framework\Form\Exception\MultipleSubmitException;
use DS3\Framework\Form\Type\TypeInterface;
use DS3\Framework\Form\Validation\ValidationContext;
use DS3\Framework\Form\Validation\Violation\Violation;

class Form implements FormInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * @var array[string]mixed
     */
    protected $data;

    /**
     * @var Field[]
     */
    protected $fields;

    /**
     * @var bool
     */
    protected $submitted;

    /**
     * @var array[string]mixed
     */
    protected $errors;

    /**
     * Form constructor.
     *
     * @param $model
     */
    public function __construct(&$model)
    {
        $this->model = $model;
        $this->fields = array();
        $this->submitted = false;
    }

    /**
     * @return object
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function addField($name, array $validators, TypeInterface $transformer)
    {
        return $this->add(new Field($name, $validators, $transformer));
    }

    public function add(Field $field)
    {
        if ($this->hasFieldWithName($field)) {
            throw new \InvalidArgumentException(
                "A field with the name {$field->getName()} already exists"
            );
        }

        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param Field $field
     *
     * @return bool
     */
    protected function hasFieldWithName(Field $field)
    {
        foreach ($this->fields as $_field) {
            if ($field->getName() == $_field->getName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array [string]mixed $data
     */
    public function submit(array $data)
    {
        if ($this->isSubmitted()) {
            throw new MultipleSubmitException('A form can\'t be submitted twice');
        }

        if (empty($this->fields)) {
            return;
        }

        $violations = array();

        foreach ($this->fields as $field) {
            $name = $field->getName();
            foreach ($field->getValidators() as $validator) {
                $ctx = new ValidationContext($name);
                $value = isset($data[$name]) ? $data[$name] : null;
                $validator->setValidationContext($ctx);
                $validator->validate($value);

                $errors = $ctx->getViolations();

                if (count($errors) > 0) {
                    foreach ($errors as $violation) {
                        $violations[] = $violation;
                    }
                } else {
                    $this->assign($name, $field->getType()->transform($value));
                }
            }
        }

        $this->errors = $violations;
        $this->submitted = true;
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->submitted;
    }

    protected function assign($name, $value)
    {
        $camelCase = ucwords($name);
        if (method_exists($this->model, "set$camelCase")) {
            call_user_func(array($this->model, "set$camelCase"), $value);
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isSubmitted() && (count($this->getErrors()) == 0);
    }

    /**
     * @return Violation[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
