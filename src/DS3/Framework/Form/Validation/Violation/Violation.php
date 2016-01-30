<?php

namespace DS3\Framework\Form\Validation\Violation;

/**
 * Represents a violation encountered while validating a given field.
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class Violation implements \JsonSerializable
{
    /**
     * The type of the violation, aka the discriminator
     * @var string
     */
    private $type;

    /**
     * The field where the violation occured
     * @var string
     */
    private $field;

    /**
     * The violation code
     * @var string
     */
    private $code;

    /**
     * A textual explanation of the violation
     * @var string
     */
    private $message;

    /**
     * Violation constructor.
     * @param string $type
     * @param string $field
     * @param string $code
     * @param string $message
     */
    public function __construct($type, $field, $code, $message)
    {
        $this->type = $type;
        $this->field = $field;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array(
            'type' => $this->getType(),
            'field' => $this->getField(),
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}