<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="text-center mb-3">Perfil</h4>
                <form id="userForm">
                    <div class="form-group">
                        <label for="nombre">Nombre: *</label>
                        <input type="text" style="width: 100%; padding: 8px; box-sizing: border-box;" id="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_paterno">Apellido Paterno: *</label>
                        <input type="text" style="width: 100%; padding: 8px; box-sizing: border-box;" id="apellido_paterno" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_materno">Apellido Materno: *</label>
                        <input type="text" style="width: 100%; padding: 8px; box-sizing: border-box;" id="apellido_materno" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_electronico">Correo Electrónico: *</label>
                        <input type="email" style="width: 100%; padding: 8px; box-sizing: border-box; background:#D8D8D8;" id="correo_electronico" readonly>
                    </div>

                    <div class="form-group position-relative" style="margin-bottom: 1rem;">
                        <label for="nueva_contrasena">Nueva Contraseña (opcional):</label>
                        <input type="password"
                            style="width: 100%; padding: 8px; box-sizing: border-box;"
                            id="nueva_contrasena"
                            placeholder="********"
                            style="padding-right: 40px;"> <!-- Espacio para el ícono -->

                        <i class="fa fa-eye-slash"
                            id="togglePassword"
                            style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #6c757d;"></i>
                    </div>
                    
                    <div class="form-group">
                        <label for="numero_control_rfc">Número de Control: *</label>
                        <input type="text" style="width: 100%; padding: 8px; box-sizing: border-box; background:#D8D8D8;" id="numero_control_rfc" readonly>
                    </div>
                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3 btn-responsive-container">
                        <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/initAdmin.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Regresar</button>
                        <button type="submit" class="btn btn-sm btn-general me-2 col-2 py-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/profileUser.js"></script>
</body>

</html>