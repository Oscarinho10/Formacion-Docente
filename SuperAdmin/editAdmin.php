<?php
include('../components/layoutSuper.php');
include('../../config/conexion.php'); // Asegúrate de incluir conexión

if (!isset($_GET['id'])) {
    echo "<script>alert('ID no proporcionado'); window.location.href='manageAdmin.php';</script>";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM administradores WHERE id_admin = $1";
$result = pg_query_params($conn, $query, array($id));

if (!$result || pg_num_rows($result) === 0) {
    echo "<script>alert('Administrador no encontrado'); window.location.href='manageAdmin.php';</script>";
    exit;
}

$admin = pg_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Edición de administradores</h4>

                <form action="procesar_editar.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $admin['id_admin']; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required value="<?php echo $admin['nombre']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_paterno">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control" required value="<?php echo $admin['apellido_paterno']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control" required value="<?php echo $admin['apellido_materno']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numero_control">Número de Control</label>
                            <input type="text" name="numero_control" class="form-control" required value="<?php echo $admin['numero_control_rfc']; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" required value="<?php echo $admin['correo_electronico']; ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="./manageAdmin.php" class="btn btn-danger mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-general btn-sm btn-editar">Guardar cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
