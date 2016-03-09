<?php

namespace DS3\Framework\Logger;

use DS3\Framework\Filesystem\File;

/**
 * Enable to write logs in a file.
 *
 * @author Sébastien Klasa <skeggib@gmail.com>
 */
class Logger
{
    private $file;
    private $timers_stack;

    /**
     * Constructor by file.
     *
     * @param File $file File where the logs will be written
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->timers_stack = new \SplStack();
    }

    /**
     * Write a '\n' at the end of the logs file.
     */
    public function __destruct()
    {
        $this->file->write("\n");
    }

    /*!
     * Write a message in logs
     * @param  string $message Message
     * @param  bool $timer   If true, timer is on until done()'s call
     * @return void
     */

    /**
     * Writes a message at the end of the logs file.
     *
     * @param string     $message
     * @param bool|false $timer   If true, the timer will be stated until the call of the method done()
     */
    public function message($message, $timer = false)
    {
        $str = "\n";

        for ($i = 0; $i < $this->timers_stack->count(); ++$i) {
            $str .= "\t";
        }

        $str .= $message;

        if ($timer) {
            if ($this->timers_stack->count() > 0) {
                $temp = $this->timers_stack->pop();
                $temp['has_childs'] = 1;
                $this->timers_stack->push($temp);
            }
            $this->timers_stack->push(array('time' => $this->millitime(), 'has_childs' => 0));
        }

        $this->file->write($str);
    }

    private function millitime()
    {
        $microtime = microtime();
        $comps = explode(' ', $microtime);

        // Note: Using a string here to prevent loss of precision
        // in case of "overflow" (PHP converts it to a double)
        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }

    /**
     * Write "Done (time ms)" where time is replaced with time elapsed since last message()'s call.
     */
    public function done()
    {
        $elapsed_time = $this->millitime() - $this->timers_stack->top()['time'];
        $has_childs = $this->timers_stack->pop()['has_childs'];

        $str = '';

        if ($has_childs) {
            $str .= "\n";
            for ($i = 0; $i < $this->timers_stack->count(); ++$i) {
                $str .= "\t";
            }
        } else {
            $str .= ' ';
        }

        $str .= 'Done ('.$elapsed_time.' ms)';

        $this->file->write($str);
    }
}
