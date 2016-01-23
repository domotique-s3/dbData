<?php
/**
 * Created by PhpStorm.
 * User: palra
 * Date: 23/01/16
 * Time: 23:57
 */

namespace DS3\Framework\Form\Validation;


class SQLFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $v = new SQLField();
        $this->assertNull($v->validate('validAlphaNumeric0123456789_'));
    }

    public function testForbiddenChars()
    {
        $v = new SQLField();
        $this->assertInternalType('string', $v->validate('h@ckerM4n!'));
    }

    public function testNull()
    {
        $v = new SQLField();
        $this->assertNull($v->validate(null));
    }
}
