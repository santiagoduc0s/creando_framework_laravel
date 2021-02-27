<?php

abstract class Model extends Crud
{

    private $class_name;
    private $exclude = [
        'class_name',
        'exclude',
        'table',
        'connection',
        'where',
        'sql'
    ];

    public function __construct($table, $class_name, $properties_extra)
    {
        parent::__construct($table);

        $this->class_name = $class_name;

        // setear atributos extra al objeto
        if (isset($properties_extra)) {
            foreach ($properties_extra as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    // -----------------------------------------------------

    public function select()
    {
        return parent::select();
    }

    public function insert($obj = null)
    {
        $obj = $this->parse($obj);
        return parent::insert($obj);
    }

    public function update($obj = null)
    {
        $obj = $this->parse($obj);
        return parent::update($obj);
    }

    public function delete()
    {
        return parent::delete();
    }

    // -----------------------------------------------------

    public function fill($obj) // no se esta utilizando 26/01
    {
        try {

            $atributos = $this->getAttributes();

            foreach ($atributos as $value) {

                if (isset($obj[$value])) {
                    $this->{$value} = $obj[$value];
                }
            }
        } catch (Exception $exc) {
            throw new Exception('Error en ' . $this->class_name . '.fill() => ' .  $exc->getMessage());
        }
    }

    private function parse($obj = null)
    {
        try {
            $objetoFinal = []; // retorno
            $atributos = $this->getAttributes(); // atributos del objeto

            if ($obj === null) {

                foreach ($atributos as $value) {

                    if (isset($this->{$value})) { // $value debe ser un atributo
                        $objetoFinal[$value] = $this->{$value};
                    }
                }
            } else {

                foreach ($atributos as $value) {

                    if (isset($obj[$value])) {
                        $objetoFinal[$value] = $obj[$value];
                    }
                }
            }
            return $objetoFinal;
        } catch (Exception $exc) {
            throw new Exception('Error en ' . $this->class_name . '.parse() => ' .  $exc->getMessage());
        }
    }

    // RETORNA LOS ATRIBUTOS DE LAS CALSES HIJAS DE MODEL
    private function getAttributes()
    {
        $atributos = [];
        $variables = get_class_vars($this->class_name);

        foreach ($variables as $key => $value) {
            if (!in_array($key, $this->exclude)) {
                $atributos[] = $key;
            }
        }

        return $atributos;
    }

    // no se usan (ahora menos porque la clase es abtracta)
    public function __get($name)
    {
        return $this->{$name};
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
}
