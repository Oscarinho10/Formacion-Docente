<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');

// ✅ PRECARGAR DATOS (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    header('Content-Type: application/json');

    $id = intval($_GET['id']);
    $query = "SELECT * FROM actividades_formativas WHERE id_actividad = $1";
    $res = pg_query_params($conn, $query, array($id));

    if ($res && pg_num_rows($res) > 0) {
        $actividad = pg_fetch_assoc($res);

        // ❌ Eliminar campos que no existen en el HTML
        unset($actividad['estado']);
        unset($actividad['descripcion_horarios']);

        // ✅ Convertir manualmente a JSON
        $output = '{';
        foreach ($actividad as $key => $value) {
            $output .= '"' . addslashes($key) . '":"' . addslashes($value) . '",';
        }
        $output = rtrim($output, ',') . '}';
        echo $output;
    } else {
        echo '{"error":"Actividad no encontrada"}';
    }
    exit;
}

// ✅ ACTUALIZACIÓN (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $id_actividad = intval($_POST['id_actividad']);

    $nombre = pg_escape_string($conn, $_POST['nombre']);
    $tipo_evaluacion = pg_escape_string($conn, $_POST['tipo_evaluacion']);
    $descripcion = pg_escape_string($conn, $_POST['descripcion']);
    $dirigido_a = pg_escape_string($conn, $_POST['dirigido_a']);
    $modalidad = pg_escape_string($conn, $_POST['modalidad']);
    $lugar = pg_escape_string($conn, $_POST['lugar']);
    $clasificacion = pg_escape_string($conn, $_POST['clasificacion']);
    $cupo = intval($_POST['cupo']);
    $total_horas = intval($_POST['total_horas']);
    $fecha_inicio = pg_escape_string($conn, $_POST['fecha_inicio']);
    $fecha_fin = pg_escape_string($conn, $_POST['fecha_fin']);

    $updates = array(
        "nombre = '$nombre'",
        "tipo_evaluacion = '$tipo_evaluacion'",
        "descripcion = '$descripcion'",
        "dirigido_a = '$dirigido_a'",
        "modalidad = '$modalidad'",
        "lugar = '$lugar'",
        "clasificacion = '$clasificacion'",
        "cupo = $cupo",
        "total_horas = $total_horas",
        "fecha_inicio = '$fecha_inicio'",
        "fecha_fin = '$fecha_fin'"
    );

    // ✅ Procesar PDF (opcional)
    if (isset($_FILES['temario_pdf']) && $_FILES['temario_pdf']['error'] == 0) {
        $pdfName = basename($_FILES['temario_pdf']['name']);
        $pdfDir = "../../uploads/temarios/";
        $pdfPath = $pdfDir . $pdfName;

        if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);
        if (move_uploaded_file($_FILES['temario_pdf']['tmp_name'], $pdfPath)) {
            $updates[] = "temario_pdf = '$pdfName'";
        }
    }

    // ✅ Procesar imagen (opcional)
    if (isset($_FILES['url_imagen']) && $_FILES['url_imagen']['error'] == 0) {
        $imgName = basename($_FILES['url_imagen']['name']);
        $imgDir = "../../uploads/imagenes/";
        $imgPath = $imgDir . $imgName;

        if (!is_dir($imgDir)) mkdir($imgDir, 0777, true);
        if (move_uploaded_file($_FILES['url_imagen']['tmp_name'], $imgPath)) {
            $updates[] = "url_imagen = '$imgName'";
        }
    }

    // ✅ Ejecutar UPDATE
    $updateQuery = "UPDATE actividades_formativas SET " . implode(", ", $updates) . " WHERE id_actividad = $id_actividad";
    $result = pg_query($conn, $updateQuery);

    if ($result) {
        // Auditoría
        $mov = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
        $nombre_act = ($mov && pg_num_rows($mov) > 0) ? pg_fetch_result($mov, 0, 'nombre') : 'Desconocido';

        $id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;
        $qUser = pg_query($conn, "SELECT nombre, apellido_paterno, apellido_materno FROM usuarios WHERE id_usuario = $id_usuario");
        $user = ($qUser && pg_num_rows($qUser) > 0) ? pg_fetch_assoc($qUser) : null;

        $nombre_usuario = $user
            ? $user['nombre'] . ' ' . $user['apellido_paterno'] . ' ' . $user['apellido_materno']
            : 'Usuario desconocido';

        $movimiento = "$nombre_usuario editó la actividad \"$nombre_act\" (ID $id_actividad)";
        registrarAuditoria($conn, $movimiento, "Actividades formativas");

        echo '{"success":true}';
    } else {
        echo '{"error":"Error al actualizar la actividad"}';
    }

    exit;
}

// ❌ Método no válido
header('Content-Type: application/json');
echo '{"error":"Acceso no permitido"}';
exit;
