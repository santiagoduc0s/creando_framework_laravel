<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Proyecto framework - Ajax, Pdo, etc.</title>
    <link href="<?= URL::to('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
</head>

<body data-urlbase="<?= URL::base() ?>">
    <div class="container">
        <div class="card mt-5">
            <div class="card-header bg-dark text-white">
                <h5>Gestión</h5>
            </div>
            <div class="card-body">
                <div class="btn-group">
                    <a href="<?= URL::to("usuarios/form/crear") ?>" class="btn btn-primary">Crear usuario</a>
                </div>
                <hr />
                <h4 class="card-title mb-4">Lista de los usuarios</h4>
                <table class="table table-condensed table-hover table-striped" width="100%" id="tablaListaUsuarios">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Edad</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">Consultando...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="<?= URL::to('assets/plugins/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= URL::to('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>