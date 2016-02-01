<?php

namespace DS3\Framework\PDO;

class FilePDOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $config = new FilePDOBuilder(__DIR__.'/pdo_unittests.cfg');

        $this->assertEquals('pgsql', $config->getDriver());
        $this->assertEquals('dbcharts', $config->getDatabaseName());
        $this->assertEquals('localhost', $config->getHost());
        $this->assertEquals('user', $config->getUsername());
        $this->assertEquals('pass', $config->getPassword());
    }
}
