<?php

namespace DS3\Framework\Form\Validation;


class AssociativeArrayValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $this->assertNull($validator->validate(null));
    }

    public function testNoErrors()
    {
        $data = array(
            'key' => 'value'
        );

        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $errors = $validator->validate($data);

        $this->assertNull($errors);
    }

    public function testNotAnArray()
    {
        $data = 2;

        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $errors = $validator->validate($data);

        $this->assertContains('array', $errors);
    }

    public function testError()
    {
        $data = array(
            'notSQLField@' => '' // Blank value
        );

        $validator = new AssociativeArrayValidator(array(new SQLFieldValidator()), array(new NotBlankValidator()));
        $errors = $validator->validate($data);

        $this->assertInternalType('array', $errors);
        $this->assertArrayHasKey('notSQLField@', $errors);
        $this->assertArrayHasKey('$key', $errors['notSQLField@']);
        $this->assertCount(1, $errors['notSQLField@']['$key']);
        $this->assertArrayHasKey('$value', $errors['notSQLField@']);
        $this->assertCount(1, $errors['notSQLField@']['$value']);
    }
}
