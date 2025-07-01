<?php
include('../../config/conexion.php');

// Verifica si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del formulario
    $nombre = $_POST['nombre_actividad'];
    $lugar = $_POST['lugar'];
    $dirigido_a = $_POST['dirigido_a'];
    $modalidad = $_POST['modalidad'];
    $clasificacion = $_POST['clasificacion'];
    $cupo = $_POST['num_participantes'];
    $total_participantes = $_POST['total_participantes'];
    $total_horas = $_POST['total_horas'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $instructores = $_POST['instructores'];

    // Manejo de archivos
    $temario_nombre = $_FILES['temario_pdf']['name'];
    $temario_tmp = $_FILES['temario_pdf']['tmp_name'];
    $url_temario = '';

    if ($temario_nombre != '') {
        $url_temario = '../../uploads/temarios/' . $temario_nombre;
        move_uploaded_file($temario_tmp, $url_temario);
    }

    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $url_imagen = '';

    if ($imagen_nombre != '') {
        $url_imagen = '../../uploads/imagenes/' . $imagen_nombre;
        move_uploaded_file($imagen_tmp, $url_imagen);
    }

    // Inserta la actividad
    $query = "INSERT INTO actividades_formativas (
        nombre, lugar, dirigido_a, modalidad, clasificacion,
        cupo, fecha_inicio, fecha_fin, hora_inicio, hora_fin,
        total_horas, temario_pdf, url_imagen
    ) VALUES (
        '$nombre', '$lugar', '$dirigido_a', '$modalidad', '$clasificacion',
        '$cupo', '$fecha_inicio', '$fecha_fin', '$hora_inicio', '$hora_fin',
        '$total_horas', '$temario_nombre', '$imagen_nombre'
    ) RETURNING id_actividad";

    $result = pg_query($conn, $query);

    if ($result && $row = pg_fetch_assoc($result)) {
        $idActividad = $row['id_actividad'];

        // Inserta relación con instructores
        foreach ($instructores as $idInstructor) {
            $idInstructor = intval($idInstructor);
            pg_query($conn, "INSERT INTO instructores_actividades (id_actividad, id_usuario) VALUES ($idActividad, $idInstructor)");
        }

        // Redirige con éxito
        header("Location: ../views/trainingActivity.php?exito=1");
        exit;
    } else {
        echo 'Error al registrar actividad.';
    }
} else {
    echo 'Acceso no válido.';
}
?>
