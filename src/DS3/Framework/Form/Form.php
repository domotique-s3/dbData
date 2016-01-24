<?php
namespace DS3\Framework\Form;


use DS3\Framework\Form\Exception\MultipleSubmitException;
use DS3\Framework\Form\Type\TypeInterface;

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
        if ($this->hasFieldWithName($field))
            throw new \InvalidArgumentException(
                "A field with the name {$field->getName()} already exists"
            );

        $this->fields[] = $field;
        return $this;
    }

    /**
     * @param Field $field
     * @return bool
     */
    protected function hasFieldWithName(Field $field)
    {
        foreach ($this->fields as $_field)
            if ($field->getName() == $_field->getName())
                return true;
        return false;
    }

    /**
     * @param array [string]mixed $data
     * @return void
     */
    public function submit(array $data)
    {
        if ($this->isSubmitted())
            throw new MultipleSubmitException('A form can\'t be submitted twice');

        if (empty($this->fields))
            return;

        $errors = array();

        foreach ($this->fields as $field) {
            $name = $field->getName();
            $errors[$name] = array();

            foreach ($field->getValidators() as $validator) {
                $value = $data[$name];
                $message = $validator->validate(
                    isset($value) ? $value : null
                );

                if ($message !== null)
                    $errors[$name][] = $message;
                else
                    $this->assign($name, $field->getType()->transform($value));
            }

            if (count($errors[$name]) == 0)
                unset($errors[$name]);
        }

        $this->errors = $errors;
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
        if (method_exists($this->model, "set$camelCase"))
            call_user_func(array($this->model, "set$camelCase"), $value);

    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isSubmitted() && (count($this->getErrors()) == 0);
    }

    /**
     * @return array[string]mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}