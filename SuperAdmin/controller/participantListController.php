<?php
include('../../config/conexion.php');

$id_actividad = intval($_GET['id_actividad']);
$fechas = array();
$sesiones = array();

// Obtener sesiones de la actividad
$querySesiones = "
    SELECT id_sesion, TO_CHAR(fecha, 'DD/MM/YYYY') as fecha 
    FROM sesiones_actividad 
    WHERE id_actividad = $id_actividad 
    ORDER BY fecha ASC
";
$resultSesiones = pg_query($conn, $querySesiones);
while ($row = pg_fetch_assoc($resultSesiones)) {
    $fechas[] = $row['fecha'];
    $sesiones[$row['id_sesion']] = $row['fecha'];
}

// Obtener usuarios inscritos (aunque no tengan asistencias)
$queryUsuarios = "
    SELECT DISTINCT u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno
    FROM usuarios u
    JOIN inscripciones i ON i.id_usuario = u.id_usuario
    WHERE i.id_actividad = $id_actividad
    ORDER BY u.nombre
";
$resultUsuarios = pg_query($conn, $queryUsuarios);

$tabla = array();
while ($user = pg_fetch_assoc($resultUsuarios)) {
    $nombreCompleto = $user['nombre'] . ' ' . $user['apellido_paterno'] . ' ' . $user['apellido_materno'];
    $asistencias = array();

    // Inicializar asistencias en "No asistió"
    foreach ($fechas as $fecha) {
        $asistencias[$fecha] = "No asistió";
    }

    // Obtener asistencias reales (si existen)
    $queryAsist = "
        SELECT a.id_sesion, a.presente
        FROM asistencias a
        JOIN sesiones_actividad s ON a.id_sesion = s.id_sesion
        WHERE s.id_actividad = $id_actividad AND a.id_usuario = " . intval($user['id_usuario']) . "
    ";
    $resAsist = pg_query($conn, $queryAsist);
    while ($asist = pg_fetch_assoc($resAsist)) {
        $fecha = isset($sesiones[$asist['id_sesion']]) ? $sesiones[$asist['id_sesion']] : null;
        if ($fecha) {
            $asistencias[$fecha] = ($asist['presente'] == 't') ? "Asistió" : "No asistió";
        }
    }

    // Verificar si tiene constancia
    $totalSesiones = count($asistencias);
    $asistio = 0;
    foreach ($asistencias as $estado) {
        if ($estado == "Asistió") {
            $asistio++;
        }
    }
    $constancia = ($totalSesiones > 0 && $asistio == $totalSesiones) ? "Sí" : "No";

    $tabla[] = array(
        'nombre' => $nombreCompleto,
        'asistencias' => $asistencias,
        'constancia' => $constancia
    );
}

header('Content-Type: application/json');
echo json_encode(array(
    'fechas' => $fechas,
    'data' => $tabla
));
?>
