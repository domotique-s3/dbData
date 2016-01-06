<?php

namespace DS3\Framework\HTTP;

/**
 * Represente la requette de l'utilisateur.
 */
class Request
{
    /* --- ATTRIBUTES --- */

    public $query;
    public $attributes;
    public $server;

    /* --- CONSTRUCTOR --- */
    public function __construct(array $query = array(), array $attributes = array(), array $server = array())
    {
        $this->server = new ParameterBag($server);
        $this->attributes = new ParameterBag($attributes);
        $this->query = new ParameterBag($query);
    }

    /* --- METHODS --- */

    /*!
     * Cree un objet Request depuis les variables globales
     * @return Request
     */
    public static function fromGlobals()
    {
        return new static($_GET, array(), $_SERVER);
    }
    /**
     * Retourne la méthode http de la requette
     */
    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD', 'GET');
    }
}
