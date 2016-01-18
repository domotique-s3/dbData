<?php

namespace DS3\Framework\Filesystem;

/**
 * Eneble files reading and writing.
 */
class File
{
    private $handle;
    private $path;

    /**
     * Open a file in read and write mode
     * @param string $path The file path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->handle = fopen($path, 'c+');
        $filesize = filesize($path);
        fseek($this->handle, $filesize);
    }

    /**
     * Closes the file
     */
    public function __destruct()
    {
        fclose($this->handle);
    }

    /**
     * Write at the end of the file
     * @param  string $str Text to write
     * @return void
     * @throws Exception if the file cannot be written
     */
    public function write($str)
    {
        if (!fwrite($this->handle, $str)) {
            throw new \Exception('Cannot write file '.$this->path);
        }
    }

    /**
     * Read the file
     * @return string File's contents
     */
    public function read()
    {
        fseek($this->handle, 0);

        $contents = '';
        while (!feof($this->handle)) {
            $contents .= fread($this->handle, 1024);
        }

        return $contents;
    }

    /**
     * Delete file's contents
     * @return void
     */
    public function clear()
    {
        file_put_contents($this->path, '');
    }

    /**
     * Check if the file exists
     * @param  string $path File's path
     * @return boolean       True if the file exists
     */
    public static function exists($path)
    {
        return file_exists($path);
    }
}
