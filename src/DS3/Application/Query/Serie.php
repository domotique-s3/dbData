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
    	$this->id = $id;
    }
}
