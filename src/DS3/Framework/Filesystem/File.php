<?php

namespace DS3\Framework\Filesystem;

/**
 * Enable read/write in a file.
 */
class File
{
    /* --- ATTRIBUTES --- */

    private $spl_file_object;

    /* --- CONSTRUCTORS --- */

    /*!
     * Path constructor, open file in r/w
     * @param string $path File path
     */
    public function __construct($path)
    {
    }

    /* --- METHODS --- */

    /*!
     * Write at the end of the file
     * @param  string $str Text to write
     * @return void
     */
    public function write($str)
    {
    }

    /*!
     * Read file
     * @return string File contents
     */
    public function read()
    {
    }

    /*!
     * Delete file contents
     * @return void
     */
    public function clear()
    {
    }
}
