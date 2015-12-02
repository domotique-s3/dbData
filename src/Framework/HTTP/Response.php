<?php
namespace DS3\Framework\HTTP

/**
* Represente la reponse envoyee a l'utilisateur
*/
class Response
{
	/* --- ATTRIBUTES --- */

	public $headers = new ParameterBag();
	private $content;

	/*! --- CONSTRUCTOR --- */
	
	/*!
	 * [__construct description]
	 * @param mixed $content Contenu de la reponse
	 * @param int $status  Status de la reponse
	 * @param mixed[] $headers En-tete
	 */
	function __construct($content, $status, $headers) {
		
	}

	/* --- METHODS --- */

	/*!
	 * Envoi la requette au client
	 * @return void
	 */
	public function send() {

	}

	/* --- GET SET --- */

	public function getContent() {

	}

	public function setContent($content) {

	}

	public function getStatusCode() {

	}

	public function setStatusCode($status_code) {
		
	}
}