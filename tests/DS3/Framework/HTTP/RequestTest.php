<?php

namespace DS3\Framework\HTTP;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $query = array(
            'a' => 1,
            'b' => 2,
        );

        $attr = array(
            'id' => 'test',
            'column' => 'col',
        );

        $server = array(
            'ping' => 'pong',
            'bim' => 'bam',
        );

        $request = new Request($query, $attr, $server);

        $this->assertEquals('GET', $request->getMethod());

        $this->assertEquals(1, $request->getQuery()->get('a'));
        $this->assertEquals(2, $request->getQuery()->get('b'));

        $this->assertEquals('test', $request->getAttributes()->get('id'));
        $this->assertEquals('col', $request->getAttributes()->get('column'));

        $this->assertEquals('pong', $request->getServer()->get('ping'));
        $this->assertEquals('bam', $request->getServer()->get('bim'));
    }

    public function testParseArrayQueryString()
    {
        $this->assertEquals('[incomplete', Request::parseQueryStringArray('[incomplete'));
        $this->assertEquals('incomplete]', Request::parseQueryStringArray('incomplete]'));
        $this->assertEquals(array(), Request::parseQueryStringArray('[]'));
        $this->assertEquals(array(), Request::parseQueryStringArray('[   ]'));
        $this->assertEquals(array(1, 2, 3), Request::parseQueryStringArray('[1,2,3]'));
        $this->assertEquals(array(1, 2, 3), Request::parseQueryStringArray('[1, 2,3]'));
        $this->assertEquals(array(1, 2, 3), Request::parseQueryStringArray('[1,2 ,3]'));
        $this->assertEquals(array(1, 2, 3), Request::parseQueryStringArray('[ 1,2,3]'));
        $this->assertEquals(array(1, 2, 3), Request::parseQueryStringArray('[1,2,3 ]'));
        $this->assertEquals(array('a', 'b', 'c'), Request::parseQueryStringArray('[a,b,c]'));
    }
}
