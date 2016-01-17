<?php

namespace DS3\Framework\Filesystem;

use DS3\Framework\Filesystem\Exception\FilesystemException;

/**
 * Enable read/write in a file.
 */
class File
{
    /**
     * @var resource The file resource
     */
    private $handle;
    private $path;

    /**
     * Opens the given file, or create it if it doesn't exists
     *
     * @param string $path File path
     */
    public function __construct($path)
    {
        $this->path = $path;

        try {
            $this->handle = fopen($this->path, 'c+');
            $filesize = filesize($this->path);
            fseek($this->handle, $filesize);
        } catch (\Exception $e) {
            throw new FilesystemException("Cannot open file {$this->path}", 0, $e);
        }
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    /**
     * Write at the end of the file
     *
     * @param  string $str Text to write
     * @return void
     * @throws FilesystemException When a writing error occurs
     */
    public function write($str)
    {
        if (!fwrite($this->handle, $str)) {
            throw new FilesystemException("Cannot write file {$this->path}");
        }
    }

    /**
     * Read the file and returns its content.
     *
     * @return string The file contents
     * @throws FilesystemException When a read error occurs
     */
    public function read()
    {
        try {
            fseek($this->handle, 0);

            $contents = '';
            while (!feof($this->handle)) {
                $contents .= fread($this->handle, 1024);
            }

            return $contents;
        } catch(\Exception $e) {
            $this->__destruct();
            throw new FilesystemException("Cannot read file {$this->path}", 0, $e);
        }
    }

    /**
     * Delete file contents
     *
     * @return void
     * @throws FilesystemException When a writing error occurs
     */
    public function clear()
    {
        try {
            file_put_contents($this->path, '');
        } catch(\Exception $e) {
            throw new FilesystemException("Cannot read file {$this->path}", 0, $e);
        }
    }

    public static function exists($path)
    {
        return file_exists($path);
    }
}
