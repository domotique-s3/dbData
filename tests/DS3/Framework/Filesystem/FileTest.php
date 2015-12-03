<?php

namespace DS3\Framework\Filesystem;

class FileTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructor() {
		$filename = "ClassFileTest_file.txt";
		if (file_exists($filename))
			unlink($filename);
		$file = new File($filename);

		$this->assertEquals(true, file_exists($filename));
	}

	public function testWriteRead() {
		$filename = "ClassFileTest_file.txt";
		if (file_exists($filename))
			unlink($filename);
		$file = new File($filename);
		$file->write("test");

		$this->assertEquals("test", $file->read());
	}

	public function testClear() {
		$filename = "ClassFileTest_file.txt";
		if (file_exists($filename))
			unlink($filename);
		$file = new File($filename);
		$file->write("test");
		$file->clear();

		$this->assertEquals("", $file->read());
	}

	public function testExists() {
		$filename = "ClassFileTest_file.txt";
		if (file_exists($filename))
			unlink($filename);
		$file = new File($filename);

		// TODO Test exists (+ mettre la methode exists en static)
	}
}