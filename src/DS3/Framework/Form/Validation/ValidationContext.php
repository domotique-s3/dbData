<?php

namespace DS3\Framework\Form\Validation;

use DS3\Framework\Form\Validation\Violation\Violation;

/**
 * Builds an array of Violations
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class ValidationContext
{
    /**
     * @var Violation[]
     */
    private $violations;

    /**
     * The field on which the violations are about
     * @var string
     */
    private $field;

    /**
     * The class of the violation
     * @var string
     */
    private $type;

    /**
     * @var ValidationContext[]
     */
    private $subContexts;

    /**
     * ValidationContext constructor.
     *
     * @param string $field The field name
     * @param string $type The type of the violation
     */
    public function __construct($field, $type = 'value')
    {
        switch ($type) {
            case 'key':
                $this->type = 'DS3\Framework\Form\Validation\Violation\KeyViolation';
                break;
            case 'value':
                $this->type = 'DS3\Framework\Form\Validation\Violation\ValueViolation';
                break;
            default:
                throw new \InvalidArgumentException("$type is not a valid violation type");
        }

        $this->field = $field;
        $this->violations = array();
        $this->subContexts = array();
    }

    /**
     * Adds a new violation
     *
     * @param $code string The code of the violation
     * @param $message string The message of the violation
     */
    public function add($code, $message)
    {
        $type = $this->type;
        $this->violations[] = new $type($this->field, $code, $message);
    }

    /**
     * Creates a sub context
     *
     * @param $field string The name of the field of the sub context
     * @param $type string|null The type of the sub context, defaults to `'value'`
     * @return ValidationContext The created sub context
     */
    public function createSubContext($field, $type = null)
    {
        if ($type == null)
            $subCtx = new ValidationContext("{$this->field}.$field");
        else
            $subCtx = new ValidationContext("{$this->field}.$field", $type);
        $this->subContexts[] = $subCtx;
        return $subCtx;
    }

    /**
     * @return Violation[]
     */
    public function getViolations()
    {
        $violations = $this->violations;
        foreach ($this->subContexts as $subContext)
            foreach ($subContext->getViolations() as $violation)
                $violations[] = $violation;

        return $violations;
    }
}