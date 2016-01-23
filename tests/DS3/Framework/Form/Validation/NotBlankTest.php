<?php

namespace DS3\Framework\Form\Validation;


class NotBlankTest extends \PHPUnit_Framework_TestCase
{
    public function testBlank()
    {
        $validator = new NotBlank();
        $this->assertInternalType('string', $validator->validate(''));
        $this->assertInternalType('string', $validator->validate(' '));
    }

    public function testNotBlank()
    {
        $validator = new NotBlank();
        $this->assertNull($validator->validate(2));
        $this->assertNull($validator->validate('Foo'));
        $this->assertNull($validator->validate(new \stdClass()));
    }

    public function testNull()
    {
        $validator = new NotBlank();
        $this->assertNull($validator->validate(null));
    }


}
