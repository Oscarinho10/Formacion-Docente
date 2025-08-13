<?php
include('config/controller/loginController.php');
include('HeadAndFoot/header.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">

    <!-- Tu CSS global (si aplica en header.php también) -->
</head>

<body>

    <div class="login-container d-flex flex-column flex-lg-row">
        <!-- Columna del formulario -->
        <div class="login-form order-lg-1">
            <?php if (isset($_GET['exp']) && $_GET['exp'] == '1'): ?>
                <div class="alert alert-warning text-center" role="alert">
                    Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente.
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <h5 class="mt-3 mb-2">Correo electrónico*</h5>
                <input type="email" name="correo" class="form-control" placeholder="Ingresa tu correo" required>

                <h5 class="mt-3 mb-2">Contraseña*</h5>
                <div class="position-relative mb-3">
                    <input type="password" name="contrasena" id="contrasenaInput" class="form-control" placeholder="Ingresa tu contraseña" required style="padding-right: 2.5rem;">
                    <i class="fa fa-eye-slash"
                        id="togglePassword"
                        style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #6c757d;">
                    </i>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100 mb-2">Iniciar sesión</button>
            </form>
            <div class="text-center">
                <button onclick="window.location.href='<?php echo BASE_URL; ?>/preRegister.php'" class="btn btn-success w-100 mb-2">Registrarse</button>
                <u><a class="text-center" data-bs-toggle="modal" data-bs-target="#modalRecuperar">¿Olvidaste tu contraseña?</a></u>
            </div>
        </div>

        <!-- Columna de información -->
        <div class="login-info order-lg-2">
            <div class="text-container">
                <h4>Sistema de formación docente</h4>
                <p>Capacitación para renovar la práctica docente, impulsar la innovación educativa y favorecer el desarrollo integral del estudiantado.</p>
            </div>
            <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" alt="icono uaem" class="img-fluid">
        </div>
    </div>

    <?php include('./config/modals/recoveryPassword.php'); ?>
    <?php
    include('HeadAndFoot/footer.php');
    ?>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/config/js/login.js"></script>