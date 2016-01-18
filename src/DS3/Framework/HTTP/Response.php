<?php

namespace DS3\Framework\HTTP;

/**
 * Represents an HTTP response.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class Response
{
    /**
     * @var string Contains the body of the response
     */
    private $content;

    /**
     * @var int The HTTP status code of the Response
     */
    private $statusCode;

    /**
     * Initializes a new Response.
     *
     * @param $content string The content of the response
     * @param $statusCode int The HTTP status of the response
     */
    public function __construct($content, $statusCode = 200)
    {
        $this->setContent($content);
        $this->setStatusCode($statusCode);
    }

    /**
     * Sends the response to the client.
     */
    public function send()
    {
        http_send_status($this->statusCode);
        $this->sendContent();
    }

    /**
     * Sends the content of the response to the client.
     */
    public function sendContent()
    {
        echo $this->content;
    }

    /**
     * @return string The content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content string The content of the response
     */
    public function setContent($content)
    {
        $this->content = (string) $content;
    }

    /**
     * @return int The HTTP status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode int The HTTP status code
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;
    }
}
