<?php

class Response
{

    // si los atributos deben ser publicos para que el json_encode funciona
    public $code;
    public $message;
    public $data;

    public function __construct($code = null, $message = null, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public static function create($code, $data = null)
    {
        $response = EMessages::getMessage($code);
        if ($data !== null) {
            $response->data = $data;
        }
        return $response; 
    }

    public function jsonEncode($obj = null)
    {
        header('Content-Type: application/json');
        return json_encode($this);
    }

    public static function json($obj)
    {
        header('Content-Type: application/json');
        if (is_array($obj) || is_object($obj)) {
            return json_encode($obj);
        }
    }

    // -------------------------------------------------------
    // revisar si son necesarios los get y los set

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setCode($value)
    {
        $this->code = $value;
    }

    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function setData($value)
    {
        $this->data = $value;
    }
}
