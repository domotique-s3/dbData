<?php

namespace DS3\Framework\Filesystem;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $filename = 'ClassFileTest_file.txt';
        if (file_exists($filename)) {
            unlink($filename);
        }

        $file = new File($filename);

        $this->assertEquals(true, file_exists($filename));

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function testWriteRead()
    {
        $filename = 'ClassFileTest_file.txt';
        if (file_exists($filename)) {
            unlink($filename);
        }
        $file = new File($filename);

        $this->assertEquals('', $file->read());

        $file->write('test');

        $this->assertEquals('test', $file->read());

        $file->write(' test2');

        $this->assertEquals('test test2', $file->read());

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function testClear()
    {
        $filename = 'ClassFileTest_file.txt';
        if (file_exists($filename)) {
            unlink($filename);
        }
        $file = new File($filename);
        $file->write('test');
        $file->clear();

        $this->assertEquals('', $file->read());

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function testExists()
    {
        $filename = 'ClassFileTest_file.txt';
        if (file_exists($filename)) {
            unlink($filename);
        }

        $this->assertEquals(false, File::exists($filename));

        $file = new File($filename);

        $this->assertEquals(true, File::exists($filename));

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
