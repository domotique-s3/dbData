<?php

namespace DS3\Framework\HTTP;

/**
 * Handles a JSONResponse
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class JsonResponse extends Response
{
    public function send()
    {
        header('Content-Type: application/json');
        parent::send();
    }

    public function setContent($content)
    {
        parent::setContent(JsonHandler::encode($content));
    }
}
