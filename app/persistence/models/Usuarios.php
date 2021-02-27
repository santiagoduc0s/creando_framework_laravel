<?php

class Usuarios extends Model
{

    protected $id;
    protected $nombres;
    protected $apellidos;
    protected $edad;
    protected $correo;
    protected $telefono;
    protected $fecha_registro;


    public function __construct($atributos_extras = null)
    {
        parent::__construct('usuarios', get_class($this), $atributos_extras);
    }

    // -----------------------------------------------------------

    public function getId()
    {
        return $this->id;
    }

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function setNombres($value)
    {
        $this->nombres = $value;
    }

    public function setApellidos($value)
    {
        $this->apellidos = $value;
    }

    public function setEdad($value)
    {
        $this->edad = $value;
    }

    public function setCorreo($value)
    {
        $this->correo = $value;
    }

    public function setTelefono($value)
    {
        $this->telefono = $value;
    }

    public function setFechaRegistro($value)
    {
        $this->fecha_registro = $value;
    }

}