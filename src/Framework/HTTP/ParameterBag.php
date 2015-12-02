<?php
namespace DS3\Framework\HTTP;

/**
* Sac de parametres, permet de stocker des valeurs associees a des cles
*/
class ParameterBag
{
	/* --- ATTRIBUTES --- */

	private $parameters = array();

	/* --- CONSTRUCTORS --- */
	
	/*!
	 * Default constructor
	 */
	public function __construct() {
		
	}

	/*!
	 * Table constructor, where table is a table of parameter
	 * @param mixed[] $parameters Parameters table
	 */

    //IN PHP, Only one constructor
	/*public function __construct($parameters) {

	}*/

	/* --- METHODS --- */

	/*!
	 * Returns all parameters
	 * @return mixed[] Parameters
	 */
	public function all() {

	}

	/*!
	 * Returns all keys
	 * @return string[] Keys
	 */
	public function keys() {

	}

	/*!
	 * Replace parameters
	 * @param  mixed[] $parameters Parameter to replace
	 * @return void
	 */
	public function replace($parameters) {

	}

	/*!
	 * Add parameters
	 * @param mixed[] $parameters Parameter to add
	 */
	public function add($parameters) {

	}

	/*!
	 * Returns parameter's value
	 * @param  string $key     Cle
	 * @param  mixed $default Default value to return if parameter doesn't exist
	 * @return mixed          Parameter's value
	 */
	public function get($key, $default = null) {

	}

	/*!
	 * Change parameter's value, create if doesn't exist
	 * @param string $key   Parameter's key
	 * @param mixed $value Parameter's value
	 */
	public function set($key, $value) {

	}

	/*!
	 * Check if a parameter exists
	 * @param  string  $key Cle
	 * @return boolean      True if parameter exists
	 */
	public function has($key) {

	}

	/*!
	 * Remove a parameter
	 * @param  string $key Parameter's key
	 * @return void
	 */
	public function remove($key) {

	}

	/*!
	 * Count number of parameters
	 * @return int Number of Parameters
	 */
	public function count() {

	}
}