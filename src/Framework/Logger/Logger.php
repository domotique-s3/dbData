<?php namespace DS3\Framework\Logger

/**
* Permet d'ecrire les logs dans un fichier
*/
class Logger
{
	/* --- ATTRIBUTES --- */

	private $file;
	private $last_message_timestamp;
	private $timers_stack;

	/* --- CONSTRUCTORS --- */

	/*!
	 * Constructeur par fichier
	 * @param File $file Fichier dans lequel seront ecrit les logs
	 */
	public function __construct($file) {
		
	}

	/* --- METHODS --- */

	/*!
	 * Ecrit un message dans les logs
	 * @param  string $message Message
	 * @param  bool $timer   Si true, le timer est lance jusque l'appel de la methode done
	 * @return void
	 */
	public function message($message, $timer) {

	}

	/*!
	 * Ecrit "Done (time ms)" ou time est remplace par le temps ecoule depuis le dernier appel de la methode message
	 * @return void
	 */
	public function done() {

	}
}