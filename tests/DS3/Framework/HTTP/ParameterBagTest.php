<?php

namespace DS3\Framework\HTTP;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $pb = new ParameterBag(array('foo' => 'bar'));
        $this->assertEquals('bar', $pb->get('foo'));
    }

    public function testSet()
    {
        $pb = new ParameterBag();
        $pb->set('Login', 'Drattak');
        $this->assertEquals('Drattak', $pb->get('Login'));
    }

    public function testAdd()
    {
        $pb = new ParameterBag();
        $parameters = array();
        $parameters['Login'] = 'Drattak';
        $pb->add($parameters);
        $this->assertEquals('Drattak', $pb->get('Login'));
    }

    public function testHas()
    {
        $pb = new ParameterBag();
        $pb->set('Login', 'Drattak');
        $this->assertEquals(true, $pb->has('Login'));
    }

    public function testAll()
    {
        $pb = new ParameterBag();
        $pb->set('Login', 'Drattak');
        $parameters['Login'] = 'Drattak';
        $this->assertEquals($parameters, $pb->all());
    }

    public function testKeys()
    {
        $pb = new ParameterBag();
        $pb->set('Login', 'Drattak');
        $pb->set('Passwd', 'Bloup');
        $keys = array('Login', 'Passwd');
        $this->assertEquals($keys, $pb->keys());
    }

    public function testReplace()
    {
        $pb = new ParameterBag();
        $pb->set('Login', 'Drattak');
        $pb->set('Passwd', 'Lou');
        $altparam['Age'] = '19';
        $pb->replace($altparam);
        $key = array('Age');
        $this->assertEquals($key, $pb->keys());
    }

    public function testRemove()
    {
        $pb = new ParameterBag(array('foo' => 'bar'));
        $pb->remove('foo');
        $this->assertEquals(null, $pb->get('foo'));
    }

    public function testCount()
    {
        $pb = new ParameterBag(array('foo' => 'bar', 'bar' => 'foo'));
        $this->assertEquals(2, $pb->count());
    }
}
