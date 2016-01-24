<?php

namespace DS3\Framework\Form\Validation;


class SequentialArrayValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $v = new SequentialArrayValidator();
        $this->assertNull($v->validate(null));
    }

    public function testNotAnArray()
    {
        $v = new SequentialArrayValidator();
        $this->assertInternalType('string', $v->validate(5));
        $this->assertInternalType('string', $v->validate('notAnArray'));
        $this->assertInternalType('string', $v->validate(new \stdClass()));
    }

    public function testValidArray()
    {
        $v = new SequentialArrayValidator(array(new NotNullValidator()));
        $data = array(1, 2, 3, 4, 5);
        $this->assertNull($v->validate($data));
    }

    public function testInvalidArray()
    {
        $v = new SequentialArrayValidator(array(new NotNullValidator()));
        $data = array(1, 2, null, 4, 5);
        $errors = $v->validate($data);

        $this->assertInternalType('array', $errors);
        $this->assertArrayHasKey(2, $errors);
        $this->assertArrayHasKey('$value', $errors[2]);
        $this->assertInternalType('array', $errors[2]['$value']);
        $this->assertInternalType('string', $errors[2]['$value'][0]);
    }
}
