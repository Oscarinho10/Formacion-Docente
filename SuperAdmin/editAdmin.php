<?php
include('../components/layoutSuper.php');
if (!isset($_GET['id'])) {
    echo "<script>alert('ID no proporcionado'); window.location.href='manageAdmin.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
</head>
<body data-id="<?php echo $_GET['id']; ?>">
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Edición de administradores</h4>

                <form action="controller/procesarEditar.php" method="post">
                    <input type="hidden" name="id" id="adminId">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_paterno">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numero_control">Número de Control</label>
                            <input type="text" name="numero_control" id="numero_control" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
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

    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/editAdmin.js"></script>
</body>
</html>
