<?php

class Uri
{

    public $uri;
    public $method;
    public $callback_function;
    public $matches;
    protected $request;
    protected $response;

    public function __construct($uri, $method, $function)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->callback_function = $function;
    }

    public function match($url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->uri); // se separa el path de los parametros
        $regex = "#^$path$#i";

        // si la uri coincide
        if (!preg_match($regex, $url, $matches)) { 
            return false;
        }

        // si el metodo http coincide
        if ($this->method != $_SERVER['REQUEST_METHOD']) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call()
    {
        try {
            
            $this->createRequest();
            if (is_string($this->callback_function)) {
                $this->functionFromController();
            } else {
                $this->executeFunction();
            }
            $this->printResponse();

        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    private function createRequest()
    {
        $this->request = new Request($_REQUEST);
        
        // se le pasa al request a matches ya que asi callback_function tiene acceso a los datos
        $this->matches[] = $this->request;
    }

    private function executeFunction() 
    {
        $this->response = call_user_func_array($this->callback_function, $this->matches);
    }

    private function printResponse()
    {
        if (is_string($this->response) || is_numeric($this->response)) {
            echo $this->response;
        } else if (is_object($this->response) || is_array($this->response)) {
            echo Response::json($this->response);
        }
    }

    private function functionFromController()
    {
        $parts = $this->getParts();
        $class = $parts['class'];
        $method = $parts['method'];
        if (!$this->importController($class)) {
            return;
        }

        $classInstance = new $class();
        $classInstance->setRequest($this->request);
        $launch = [$classInstance, $method];

        if (is_callable($launch)) {
            $this->response = call_user_func_array($launch, $this->matches);
        } else {
            throw new Exception("El metodo $class->$method no existe.");
        }

    }

    private function getParts()
    {
        $parts = [];
        if (strpos($this->callback_function, '@') !== false) {
            $methodParts = explode('@', $this->callback_function);
            $parts['class'] = $methodParts[0];
            $parts['method'] = $methodParts[1];
        }
        return $parts;
    }

    private function importController($class)
    {
        $file = PATH_CONTROLLERS . $class . '.php';
        if (!file_exists($file)) {
            throw new Exception("El controlador ($class) no existe.");
            return false;
        }
        require_once $file;
        return true;
    }
}
