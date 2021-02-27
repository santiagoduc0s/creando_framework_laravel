<?php

class Request
{
    protected $url_request;
    protected $data;
    public $method;

    public function __construct($request, $flag = true)
    {
        $this->url_request = $request;
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->extractData();
        $this->setExtraData($flag);
    }

    private function extractData()
    {
        $this->data = [];
        foreach ($this->url_request as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $this->data[$key] = new Request($value, false); // por ahora no sucede
            } else {
                if ($key != 'http_referer') {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    private function setExtraData($flag)
    {
        if ($flag == true) {
            $this->data['http_referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
            $headers = apache_request_headers();
            $this->data['headers'] = new Request($headers, false);
            //$this->data['server'] = new Request($_SERVER, false); // se puede borrar
        }
    }

    // --------------------------------------------------------------------------------------------------------

    public function getAllData()
    {
        return $this->data;
    }

    public function __get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

}