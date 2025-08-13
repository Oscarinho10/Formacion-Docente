<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Administrador</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Registro de administradores</h4>

                <form action="../SuperAdmin/controller/procesar_agregar.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre">Nombre: </label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_paterno">Apellido Paterno: </label>
                            <input type="text" name="apellido_paterno" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_materno">Apellido Materno: </label>
                            <input type="text" name="apellido_materno" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_control">Número de Control o RFC: </label>
                            <input type="text" name="numero_control" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_nacimiento">Fecha de Nacimiento: </label>
                            <input type="date" name="fecha_nacimiento" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sexo">Sexo: </label>
                            <select name="sexo" class="form-select" required>
                                <option value="">Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="correo">Correo Electrónico: </label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="./manageAdmin.php" class="btn btn-danger me-2">Cancelar</a>
                        <button type="submit" class="btn btn-general btn-sm btn-registar">Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/addAdmin.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>