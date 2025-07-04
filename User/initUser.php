<?php
include_once('../config/verificaRol.php');
verificarRol('participante'); // Esto asegura el acceso solo a participantes

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