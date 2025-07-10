<?php
include_once('../config/verificaRol.php');
verificarRol('instructor'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutInstructor.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="form-title">Perfil de Usuario</h2>
            <form id="userForm">
                <div class="form-group">
                    <label for="nombre">Nombre: *</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellidoPaterno">Apellido Paterno: *</label>
                    <input type="text" class="form-control" id="apellido_paterno" required>
                </div>
                <div class="form-group">
                    <label for="apellidoMaterno">Apellido Materno: *</label>
                    <input type="text" class="form-control" id="apellido_materno" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico: </label>
                    <input type="email" class="form-control" style="width: 100%; padding: 8px; box-sizing: border-box; background:#D8D8D8;" id="correo_electronico" readonly>
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
                    <label for="numeroControl">Número de Control: </label>
                    <input type="text" class="form-control" style="width: 100%; padding: 8px; box-sizing: border-box; background:#D8D8D8;" id="numero_control_rfc" readonly>
                </div>
                <!-- Botones -->
                <div class="d-flex justify-content-end mt-3">
                    <button onclick="window.location.href='<?php echo BASE_URL; ?>/Instructor/instructorCertificate.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Regresar</button>
                    <button type="submit" class="btn btn-sm btn-general col-2">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Instructor/js/profileUser.js"></script>
</body>

</html>