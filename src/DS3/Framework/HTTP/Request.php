<?php
namespace DS3\Framework\HTTP

/**
* Represente la requette de l'utilisateur
*/
class Request
{
	/* --- ATTRIBUTES --- */

	public $server = new ParameterBag();
	public $attributes = new ParameterBag();
	public $query = new ParameterBag();
	public $post = new ParameterBag();
	public $cookies = new ParameterBag();
	public $headers = new ParameterBag();

	/* --- METHODS --- */

	/*!
	 * Cree un objet Request depuis les variables globales
	 * @return Request
	 */
	public function fromGlobals() {

	}
}