<?php

namespace DS3\Framework\HTTP;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCtor()
    {
        $res = new Response('hey', 200);
        $this->assertSame('hey', $res->getContent());
        $this->assertSame(200, $res->getStatusCode());
    }

    public function testTypeCast()
    {
        $res = new Response(5, '200');
        $this->assertSame('5', $res->getContent());
        $this->assertSame(200, $res->getStatusCode());
    }
}
