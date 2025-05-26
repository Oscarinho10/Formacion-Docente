<?php

?>

<?php
include './config/conexion.php'; // o 'config/conexion.php' si lo pusiste en una carpeta
// Ya puedes usar $conn aquí para hacer consultas
?>

<?php include './HeadAndFoot/header.php'; ?>

<!-- LOGIN -->
<div class="login-container">
    <!-- Columna del formulario -->
    <div class="login-form">
        <h5 class="mb-4">Correo electrónico*</h5>
        <input type="email" class="form-control" placeholder="Ingresa tu correo">

        <h5 class="mt-3 mb-2">Contraseña*</h5>
        <input type="password" class="form-control" placeholder="Ingresa tu contraseña">

        <button class="btn btn-primary w-100">Iniciar sesión</button>
        <a href="#" class="small-link">¿Olvidaste tu contraseña?</a>

        <a href="./preRegister.php" class="btn btn-success w-100">Registrarse</a>
    </div>

    <!-- Columna de información -->
    <div class="login-info">
        <div class="text-container">
            <h4>Sistema de formación docente</h4>
            <p>Capacitación para renovar la práctica docente, impulsar la innovación educativa y favorecer el desarrollo integral del estudiantado.</p>
        </div>
        <img src="./img/logo_blanco2.png" alt="icono uaem" class="img-fluid">
    </div>

</div>

<?php include './HeadAndFoot/footer.php'; ?>