<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../config/verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'participante') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layout.php');

?>


<div class="card-container1">

    <a href="./ActivityUser.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/actividad_formativa.png" alt="Actividad Formativa">
        <div class="card-title2">Actividad formativa</div>
    </a>
    <a href="./participantCertificate.php" class="card2">
        <img src="<?php echo BASE_URL; ?>/assets/img/participantes.png" alt="Asistencia">
        <div class="card-title2">Constancia participantes</div>
    </a>
</div>