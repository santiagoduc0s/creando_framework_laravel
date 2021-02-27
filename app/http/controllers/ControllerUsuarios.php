<?php

class ControllerUsuarios extends Controller
{
    private $usuarioModel;
    private $response;

    public function __construct()
    {
        $this->usuarioModel = new Usuarios();
        $this->response = null;
    }

    public function index()
    {
        return $this->view('welcome');
    }

    public function listarUsuarios()
    {
        $listaUsuarios = $this->usuarioModel->select();

        if (is_array($listaUsuarios)) {
            if (count($listaUsuarios) > 0) {
                $this->response = Response::create(EMessages::LISTADO_EXITOSO, $listaUsuarios);
            } elseif (count($listaUsuarios) == 0) {
                $this->response = Response::create(EMessages::NO_HAY_REGISTROS);
            }
        } else {
            $this->response = Response::create(EMessages::ERROR);
        }

        return $this->response;
    }

    public function buscarUsuario($idUsuario)
    {
        $usuarioBusqueda = $this->usuarioModel
            ->whereAnd(['id', '=', $idUsuario])
            ->first();

        if (is_object($usuarioBusqueda)) {
            $this->response = Response::create(EMessages::BUSQUEDA_EXITOSA, $usuarioBusqueda);
        } elseif (is_null($usuarioBusqueda)) {
            $this->response = Response::create(EMessages::REGISTRO_NO_ENCONTRADO);
        } else {
            $this->response = Response::create(EMessages::ERROR);
        }

        return $this->response;
    }

    public function insertarUsuario($usuario)
    {
        $id = $this->usuarioModel->insert($usuario);

        if ($id > 0) {
            $this->response = Response::create(EMessages::INSERCION_EXITOSA, $id);
        } else if ($id == 0) {
            $this->response = Response::create(EMessages::INSERCION_ERRONEA); // existe el caso?
        } else if ($id == -1) {
            $this->response = Response::create(EMessages::ERROR);
        } else if ($id == -2) {
            $this->response = Response::create(EMessages::CORREO_DUPLICADO);
        }

        return $this->response;
    }

    public function actualizarUsuario($usuario)
    {
        $filasAfectadas = $this->usuarioModel
            ->whereAnd(['id', '=', $usuario['idUsuario']])
            ->update($usuario);

        if ($filasAfectadas > 0) {
            $this->response = Response::create(EMessages::ACTUALIZACION_EXITOSA, $filasAfectadas);
        } else if ($filasAfectadas == 0) {
            $this->response = Response::create(EMessages::ACTUALIZACION_ERRONEA);
        } else if ($filasAfectadas == -1) {
            $this->response = Response::create(EMessages::ERROR);
        } else if ($filasAfectadas == -2) {
            $this->response = Response::create(EMessages::CORREO_DUPLICADO);
        }

        return $this->response;
    }

    public function eliminarUsuario($idUsuario)
    {
        $filasAfectadas = $this->usuarioModel
            ->whereAnd(['id', '=', $idUsuario])
            ->delete();

        if ($filasAfectadas > 0) {
            $this->response = Response::create(EMessages::ELIMINACION_EXITOSA, $filasAfectadas);
        } elseif ($filasAfectadas == 0) {
            $this->response = Response::create(EMessages::ELIMINACION_ERRONEA);
        } else {
            $this->response = Response::create(EMessages::ERROR);
        }

        return $this->response;
    }
}
