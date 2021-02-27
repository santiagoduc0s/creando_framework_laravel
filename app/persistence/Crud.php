<?php

abstract class Crud
{

    protected $table;
    protected $conection;
    protected $where;
    protected $sql;
    private $stm;

    public function __construct($table)
    {
        $this->table = $table;
        $this->conection = Connection::getConnection();
        $this->where = '';
        $this->sql = '';
        $this->stm = null;
    }

    protected function select()
    {
        try {

            $this->sql = "SELECT * FROM {$this->table} {$this->where}";
            $stm = $this->prepareQuery();
            $this->resetValues();

            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            return -1;
        }
    }

    public function first()
    {
        $usuarioBusqueda = $this->select();
        if (isset($usuarioBusqueda[0]) && is_array($usuarioBusqueda)) {
            return $usuarioBusqueda[0];
        } else if ($usuarioBusqueda == -1) {
            return -1;
        } elseif (count($usuarioBusqueda) == 0) {
            return null;
        }
    }

    protected function insert($obj)
    {
        try {
            $claves = array_keys($obj); // ['nombres', 'apellidos', 'edad']

            $campos = implode(', ', $claves); // nombres, apellidos, edad
            $valores = ':' . implode(', :', $claves); // :nombres, :apellidos, :edad

            $this->sql = "INSERT INTO {$this->table} ({$campos}) VALUES ({$valores})";
            // INSERT INTO usuarios (nombres, apellidos, edad) VALUES (:nombres, :apellidos, :edad)

            $filasAfectadas = $this->executeQuery($obj); // 0 = error

            return $this->conection->lastInsertId();
        } catch (PDOException $exc) {
            
            // TODO: CREAR UNA FUNCION PARA LOS ERRORES SQL
            $error = $this->stm->errorInfo();
            switch ($error[0]) {
                case '23000':
                    return -2;
                default:
                    return -1;
            }

        } catch (Exception $exc) {
            return -1;
        }
    }

    protected function update($obj)
    {
        if (!empty($this->where)) {

            try {

                $camposYvalores = '';
                foreach ($obj as $key => $value) {
                    $camposYvalores .= "{$key} = :{$key}, ";
                }
                $camposYvalores = rtrim($camposYvalores, ', ');

                $this->sql = "UPDATE {$this->table} SET {$camposYvalores} {$this->where}";

                return $filasAfectadas = $this->executeQuery($obj);
            } catch (PDOException $exc) {
                $error = $this->stm->errorInfo();
                switch ($error[0]) {
                    case '23000':
                        return -2;
                    default:
                        return -1;
                }
            } catch (Exception $exc) {
                return -1;
            }
        } else {
            throw new Exception("No se agregaron restricciones de busqueda a la consulta.");
        }
    }

    public function delete()
    {
        if (!empty($this->where)) {

            try {

                $this->sql = "DELETE FROM {$this->table} {$this->where}";
                return $filasAfectadas = $this->executeQuery();
            } catch (Exception $exc) {
                return -1;
            }
        } else {
            throw new Exception("No se agregaron restricciones de busqueda a la consulta.");
        }
    }

    public function whereAnd(...$wheres)
    {
        try {

            foreach ($wheres as $value) {
                $this->where .= (strpos($this->where, 'WHERE') === false) ? 'WHERE ' : ' AND ';
                $this->where .= "{$value[0]} {$value[1]} " . (is_string($value[2]) ? "\"{$value[2]}\"" : "{$value[2]}");
            }

            return $this;
        } catch (Exception $exc) {
            echo 'Ocurrio un error: ' . $exc->getMessage();
        }
    }

    public function whereOr(...$wheres)
    {
        try {

            foreach ($wheres as $value) {
                $this->where .= (strpos($this->where, 'WHERE') === false) ? 'WHERE ' : ' OR ';
                $this->where .= "{$value[0]} {$value[1]} " . (is_string($value[2]) ? "\"{$value[2]}\"" : "{$value[2]}");
            }

            return $this;
        } catch (Exception $exc) {
            echo 'Ocurrio un error: ' . $exc->getMessage();
        }
    }

    private function executeQuery($obj = null)
    {
        $this->stm = $this->prepareQuery();
        $this->resetValues();

        if ($obj !== null) {
            foreach ($obj as $key => $value) {

                $value = empty($value) ? null : $value; // '' = null
                $this->stm->bindValue(":{$key}", $value, $this->getType($value));
            }
        }

        $this->stm->execute();
        return $this->stm->rowCount();
    }

    private function prepareQuery()
    {
        if (!empty($this->sql)) {
            return $this->conection->prepare(rtrim($this->sql, ' '));
        }
        return null;
    }

    private function getType($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'string':
                return PDO::PARAM_STR;
            case 'integer':
                return PDO::PARAM_INT;
            case 'NULL':
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    private function resetValues()
    {
        $this->sql = '';
        $this->where = '';
        $this->stm = null; 
    }
}
