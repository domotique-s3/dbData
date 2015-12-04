<?php

namespace DS3\Application\Query;

/**
 * Serie
 */
class Serie
{
    /* --- ATTRIBUTES --- */

    private $id;

    /* --- GETTERS --- */

    /*!
     * Returns serie's id
     */
    public function getId () 
    {
    	return $this->id;
    }

    /* --- SETTERS --- */

    /*!
     * Sets serie's id
     */
    public function setId ($id) 
    {
    	if(is_int($id)){
    		$this->id = $id;
    	} else {
    		throw new Exception("Param '". $id . "' is not an integer");
    	}
    }
}
