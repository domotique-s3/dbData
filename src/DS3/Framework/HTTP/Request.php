<?php

namespace DS3\Framework\HTTP;

/**
 * Represents an HTTP request.
 */
class Request
{
    /**
     * @var ParameterBag
     */
    private $query;

    /**
     * @var ParameterBag
     */
    private $attributes;

    /**
     * @var ParameterBag
     */
    private $server;

    /**
     * Request constructor.
     *
     * @param array $query The query parameters
     * @param array $attributes Some arbitrary attributes, you can use them for you business logic
     * @param array $server The server parameters
     */
    public function __construct(
        array $query = array(),
        array $attributes = array(),
        array $server = array()
    )
    {
        $this->server = new ParameterBag($server);
        $this->attributes = new ParameterBag($attributes);
        $this->query = new ParameterBag($query);
    }

    /**
     * Creates a Request from super globals.
     *
     * @return Request
     */
    public static function fromGlobals()
    {
        $recursiveTransform = function (array $array) use (&$recursiveTransform) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $recursiveTransform($array[$key]);
                } else {
                    $array[$key] = Request::parseQueryStringArray($array[$key]);
                }
            }

            return $array;
        };

        return new static($recursiveTransform($_GET), array(), $_SERVER);
    }

    /**
     * Transforms a query string parameter into an array, if the parameter follows the good
     * syntax.
     *
     * @param $value string The parameter to parse
     *
     * @return array|string The array, if parsed successfuly,the input string otherwise
     */
    public static function parseQueryStringArray($value)
    {
        if (!preg_match('/^\[.*\]$/', $value)) {
            return $value;
        }

        // Removing square brackets
        $value = substr($value, 1);
        $value = substr($value, 0, -1);
        $value = trim($value);
        if ($value == '') {
            return array();
        }

        // Exploding string
        $exploded = explode(',', $value);

        // And trim their values
        foreach ($exploded as $i => $item) {
            $exploded[$i] = trim($item);
        }

        return $exploded;
    }

    /**
     * Returns the HTTP method of this request.
     *
     * @return string The HTTP method of the request
     */
    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD', 'GET');
    }

    /**
     * @return ParameterBag The query parameters
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return ParameterBag The request attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return ParameterBag The server parameters
     */
    public function getServer()
    {
        return $this->server;
    }
}
