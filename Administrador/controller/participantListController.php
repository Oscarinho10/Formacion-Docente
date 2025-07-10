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

// Obtener usuarios inscritos
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

    // Obtener asistencias reales
    $queryAsist = "
        SELECT a.id_sesion, a.presente
        FROM asistencias a
        JOIN sesiones_actividad s ON a.id_sesion = s.id_sesion
        WHERE s.id_actividad = $id_actividad AND a.id_usuario = " . intval($user['id_usuario']) . "
    ";
    $resAsist = pg_query($conn, $queryAsist);
    while ($asist = pg_fetch_assoc($resAsist)) {
        $id_sesion = $asist['id_sesion'];
        $fecha = isset($sesiones[$id_sesion]) ? $sesiones[$id_sesion] : null;
        if ($fecha !== null) {
            $asistencias[$fecha] = ($asist['presente'] == 't') ? "Asistió" : "No asistió";
        }
    }

    // Verificar constancia
    $totalSesiones = count($asistencias);
    $asistio = 0;
    foreach ($asistencias as $estado) {
        if ($estado == "Asistió") {
            $asistio++;
        }
    }
    $constancia = ($totalSesiones > 0 && $asistio == $totalSesiones) ? "Sí" : "No";

    // Obtener id_inscripcion
    $id_usuario = intval($user['id_usuario']);
    $id_inscripcion = null;
    $queryInscripcion = "
        SELECT id_inscripcion 
        FROM inscripciones 
        WHERE id_usuario = $id_usuario 
          AND id_actividad = $id_actividad
        LIMIT 1
    ";
    $resInscripcion = pg_query($conn, $queryInscripcion);
    if ($resInscripcion && pg_num_rows($resInscripcion) > 0) {
        $rowIns = pg_fetch_assoc($resInscripcion);
        $id_inscripcion = $rowIns['id_inscripcion'];
    }

    // Verificar entrega (si aplica)
    $entregado = "No aplica";
    if ($id_inscripcion !== null) {
        $queryEntrega = "SELECT entregado FROM entregas_actividad WHERE id_inscripcion = $id_inscripcion LIMIT 1";
        $resEntrega = pg_query($conn, $queryEntrega);
        if ($resEntrega && pg_num_rows($resEntrega) > 0) {
            $rowEntrega = pg_fetch_assoc($resEntrega);
            $entregado = ($rowEntrega['entregado'] == 't') ? "Entregado" : "No entregado";
        }
    }


    $tabla[] = array(
        'nombre' => $nombreCompleto,
        'asistencias' => $asistencias,
        'constancia' => $constancia,
        'entregado' => $entregado
    );
}

header('Content-Type: application/json');
echo json_encode(array(
    'fechas' => $fechas,
    'data' => $tabla
));
