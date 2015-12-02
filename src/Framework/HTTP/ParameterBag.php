<?php namespace DS3\Framework\HTTP

/**
* Sac de parametres, permet de stocker des valeurs associees a des cles
*/
class ParameterBag
{
	/* --- ATTRIBUTES --- */

	private $parameters = array();

	/* --- CONSTRUCTORS --- */
	
	/*!
	 * Constructeur par defaut
	 */
	public function __construct() {
		
	}

	/*!
	 * Contructeur par tableau de parametres
	 * @param mixed[] $parameters Tableau de parametres
	 */
	public function __construct($parameters) {

	}

	/* --- METHODS --- */

	/*!
	 * Retourne tout les parametres
	 * @return mixed[] Parametres
	 */
	public function all() {

	}

	/*!
	 * Retourne toute les cles
	 * @return string[] Cles
	 */
	public function keys() {

	}

	/*!
	 * Remplace les parametres
	 * @param  mixed[] $parameters Parametres a remplacer
	 * @return void
	 */
	public function replace($parameters) {

	}

	/*!
	 * Ajoute les parametres
	 * @param mixed[] $parameters Parametres a ajouter
	 */
	public function add($parameters) {

	}

	/*!
	 * Retourne la valeur d'un parametre
	 * @param  string $key     Cle
	 * @param  mixed $default Valeur a retourner par defaut si le parametre n'existe pas
	 * @return mixed          La valeur du parametre
	 */
	public function get($key, $default = null) {

	}

	/*!
	 * Change la valeur d'un parametre, cree le parametre s'il n'existe pas
	 * @param string $key   Cle du parametre
	 * @param mixed $value Valeur du parametre
	 */
	public function set($key, $value) {

	}

	/*!
	 * Verifie si un parametre existe
	 * @param  string  $key Cle
	 * @return boolean      True si le parametre existe
	 */
	public function has($key) {

	}

	/*!
	 * Supprime un parametre
	 * @param  string $key Cle du parametre a supprimer
	 * @return void
	 */
	public function remove($key) {

	}

	/*!
	 * Compte le nombre de parametres
	 * @return int Nombre de parametres
	 */
	public function count() {

	}
}