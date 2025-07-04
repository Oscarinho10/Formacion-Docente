<?php
include('config/controller/loginController.php');
?>

<?php include('HeadAndFoot/header.php'); ?>

<!-- LOGIN -->
<div class="login-container">
    <!-- Columna del formulario -->
    <div class="login-form">

        <?php if (isset($_GET['exp']) && $_GET['exp'] == '1'): ?>
            <div class="alert alert-warning text-center" role="alert">
                Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente.
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <h5 class="mt-3 mb-2">Correo electrónico*</h5>
            <input type="email" name="correo" class="form-control" placeholder="Ingresa tu correo" required>

            <h5 class="mt-3 mb-2">Contraseña*</h5>
            <input type="password" name="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>

            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>

        <button onclick="window.location.href='<?php echo BASE_URL; ?>/preRegister.php'" class="btn btn-success w-100">Registrarse</button>
        <a href="#" class="small-link">¿Olvidaste tu contraseña?</a>
    </div>

    <!-- Columna de información -->
    <div class="login-info">
        <div class="text-container">
            <h4>Sistema de formación docente</h4>
            <p>Capacitación para renovar la práctica docente, impulsar la innovación educativa y favorecer el desarrollo integral del estudiantado.</p>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" alt="icono uaem" class="img-fluid">
    </div>
</div>

<?php include('HeadAndFoot/footer.php'); ?>
