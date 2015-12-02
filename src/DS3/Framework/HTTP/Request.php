<?php

namespace DS3\Framework\HTTP;

/**
 * Represente la requette de l'utilisateur.
 */
class Request
{
    /* --- ATTRIBUTES --- */

    public $server;
    public $attributes;
    public $query;
    public $post;
    public $cookies;
    public $headers;

    /* --- CONSTRUCTOR --- */
    public function __construct()
    {
        $this->server = new ParameterBag();
        $this->attributes = new ParameterBag();
        $this->query = new ParameterBag();
        $this->post = new ParameterBag();
        $this->cookies = new ParameterBag();
        $this->headers = new ParameterBag();
    }

    /* --- METHODS --- */

    /*!
     * Cree un objet Request depuis les variables globales
     * @return Request
     */
    public function fromGlobals()
    {
    }
}
