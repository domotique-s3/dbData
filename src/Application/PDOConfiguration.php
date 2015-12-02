<?php namespace DS3\Application;

/**
* Configuration de la base de donnees
*/
abstract class PDOConfiguration
{
	/* --- ATTRIBUTES --- */

	protected $login;
	protected $passwd;
	protected $database_name;

	/* --- METHODS --- */

	/*!
	 * Retourne le login de l'utilisateur
	 */
	public function getLogin() {
		return $this->login;
	}

	/*!
	 * Retourne le mot de passe de l'utilisateur
	 */
	public function getPassword() {
		return $this->passwd;
	}

	/*!
	 * Retourne le nom de la BDD
	 */
	public function getDatabaseName() {
		return $this->database_name;
	}

	/*!
	 * Retourne le PDO configure
	 */
	public function getPDO();
}