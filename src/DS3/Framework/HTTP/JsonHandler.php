<?php

namespace DS3\Framework\HTTP;

class JsonHandler
{
    public static function encode($data)
    {
        $output = null;
        if ($data instanceof \Exception) {
            $output = self::exceptionToArray($data);
        } else {
            $output = $data;
        }

        return json_encode($output);
    }

    public static function exceptionToArray(\Exception $e)
    {
        $a = array(
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        );

        if ($e->getPrevious() !== null) {
            $a['previous'] = self::exceptionToArray($e->getPrevious());
        }

        return $a;
    }
}
