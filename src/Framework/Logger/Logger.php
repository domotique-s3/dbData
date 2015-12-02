<?php
namespace DS3\Framework\Logger;

/**
* Enable to write logs in a file
*/
class Logger
{
	/* --- ATTRIBUTES --- */

	private $file;
	private $last_message_timestamp;
	private $timers_stack;

	/* --- CONSTRUCTORS --- */

	/*!
	 * File constructor
	 * @param File $file File in which logs will be written
	 */
	public function __construct($file) {
		
	}

	/* --- METHODS --- */

	/*!
	 * Write a message in logs
	 * @param  string $message Message
	 * @param  bool $timer   If true, timer is on until done()'s call
	 * @return void
	 */
	public function message($message, $timer) {

	}

	/*!
	 * Write "Done (time ms)" where time is replaced with time elapsed since last message()'s call
	 * @return void
	 */
	public function done() {

	}
}