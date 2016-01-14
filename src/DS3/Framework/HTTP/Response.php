<?php

namespace DS3\Framework\HTTP;

/**
 * Represente la reponse envoyee a l'utilisateur.
 */
class Response
{
    /* --- ATTRIBUTES --- */

    public $headers;
    private $content;
    private $status;

    /*! --- CONSTRUCTOR --- */

    /*!
     * [__construct description]
     * @param mixed $content Contenu de la reponse
     * @param int $status  Status de la reponse
     * @param mixed[] $headers En-tete
     */
    public function __construct($content, $status = 200, $headers = array())
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = new ParameterBag();
    }

    /* --- METHODS --- */

    /*!
     * Envoi la requette au client
     * @return void
     */
    public function send()
    {
        echo json_encode($this->content);
    }

    /* --- GET SET --- */

    public function getContent()
    {
    }

    public function setContent($content)
    {
    }

    public function getStatusCode()
    {
    }

    public function setStatusCode($status_code)
    {
    }
}
