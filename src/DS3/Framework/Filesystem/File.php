<?php

namespace DS3\Framework\Filesystem;

/**
 * Enable read/write in a file.
 */
class File
{
    /* --- ATTRIBUTES --- */

    private $handle;
    private $path;

    /* --- CONSTRUCTORS --- */

    /*!
     * Path constructor, open file in r/w
     * @param string $path File path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->handle = fopen($path, "c+");
        $filesize = filesize($path);
        fseek($this->handle, $filesize);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    /* --- METHODS --- */

    /*!
     * Write at the end of the file
     * @param  string $str Text to write
     * @return void
     */
    public function write($str)
    {
        if (!fwrite($this->handle, $str))
            throw new \Exception("Cannot write file " . $this->path);
    }

    /*!
     * Read file
     * @return string File contents
     */
    public function read()
    {
        fseek($this->handle, 0);
        
        $contents = "";
        do {
            $contents .= fread($this->handle, 1024);
        } while (!feof($this->handle) && $contents != "");

        return $contents;
    }

    /*!
     * Delete file contents
     * @return void
     */
    public function clear()
    {
        file_put_contents($this->path, "");
    }


    public static function exists($path)
    {
        return file_exists($path);
    }
}
