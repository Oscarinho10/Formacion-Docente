<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

include('../components/layoutAdmin.php'); // Aquí sí puedes incluir lo demás
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
