<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>


<div class="card-container2">
    <a href="listParticipants.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/solicitud.png" alt="Solicitudes">
        <div class="card-title2">Solicitudes</div>
    </a>

    <a href="listInstructors.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/instructor.png" alt="Instructores">
        <div class="card-title2">Instructores</div>
    </a>

    <a href="listActivitys.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/actividad_formativa.png" alt="Actividad Formativa">
        <div class="card-title2">Actividad formativa</div>
    </a>

    <a href="listAssists.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/asistencia.png" alt="Asistencia">
        <div class="card-title2">Asistencia</div>
    </a>
</div>