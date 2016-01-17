<?php

namespace DS3\Application;

class FilePDOConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $config = new FilePDOConfiguration('pdo_unittests.cfg');

        $this->assertEquals('pgsql', $config->getConnector());
        $this->assertEquals('dbcharts', $config->getDatabaseName());
        $this->assertEquals('localhost', $config->getHost());
        $this->assertEquals('user', $config->getLogin());
        $this->assertEquals('pass', $config->getPassword());
    }
}
