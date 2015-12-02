<?php namespace DS3\Framework\Filesystem

/**
* Permet la lecture et l'ecriture dans un fichier
*/
class File
{
	/* --- ATTRIBUTES --- */

	private $spl_file_object;
	
	/* --- CONSTRUCTORS --- */

	/*!
	 * Constructeur par chemin, ouvre le fichier en lecture et ecriture
	 * @param string $path Chemin du fichier
	 */
	public function __construct($path) {
		
	}

	/* --- METHODS --- */

	/*!
	 * Ecrit a la fin du fichier
	 * @param  string $str Texte a ecrire
	 * @return void
	 */
	public function write($str) {

	}

	/*!
	 * Lit le fichier
	 * @return string Le contenu du fichier
	 */
	public function read() {

	}

	/*!
	 * Efface le contenu du fichier
	 * @return void
	 */
	public function clear() {

	}
}