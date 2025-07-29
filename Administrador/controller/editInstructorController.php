<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');

// ✅ PRECARGAR DATOS (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    header('Content-Type: application/json');

    $id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id_usuario = $1 AND rol = 'instructor'";
    $res = pg_query_params($conn, $query, array($id));

    if ($res && pg_num_rows($res) > 0) {
        $row = pg_fetch_assoc($res);

        // Convertir el array manualmente a JSON
        $output = '{';
        foreach ($row as $key => $value) {
            $output .= '"' . addslashes($key) . '":"' . addslashes($value) . '",';
        }
        $output = rtrim($output, ',') . '}';
        echo $output;
    } else {
        echo '{"error":"Instructor no encontrado"}';
    }

    exit;
}

// ✅ ACTUALIZACIÓN (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = intval($_POST['id_usuario']);

    $nombre = pg_escape_string($conn, $_POST['nombre']);
    $apellido_paterno = pg_escape_string($conn, $_POST['apellido_paterno']);
    $apellido_materno = pg_escape_string($conn, $_POST['apellido_materno']);
    $fecha_nacimiento = pg_escape_string($conn, $_POST['fecha_nacimiento']);
    $sexo = pg_escape_string($conn, $_POST['sexo']);
    $correo_electronico = pg_escape_string($conn, $_POST['correo_electronico']);
    $numero_control_rfc = pg_escape_string($conn, $_POST['numero_control_rfc']);
    $unidad_academica = pg_escape_string($conn, $_POST['unidad_academica']);
    $grado_academico = pg_escape_string($conn, $_POST['grado_academico']);
    $perfil_academico = pg_escape_string($conn, $_POST['perfil_academico']);

    $query = "
        UPDATE usuarios SET 
            nombre = '$nombre',
            apellido_paterno = '$apellido_paterno',
            apellido_materno = '$apellido_materno',
            fecha_nacimiento = '$fecha_nacimiento',
            sexo = '$sexo',
            correo_electronico = '$correo_electronico',
            numero_control_rfc = '$numero_control_rfc',
            unidad_academica = '$unidad_academica',
            grado_academico = '$grado_academico',
            perfil_academico = '$perfil_academico'
        WHERE id_usuario = $id_usuario
    ";

    $result = pg_query($conn, $query);

    header('Content-Type: application/json');

    if ($result) {
        // Auditoría
        $movimiento = "Editó los datos del instructor \"$nombre $apellido_paterno $apellido_materno\" (ID $id_usuario)";
        $modulo = "Instructores";
        registrarAuditoria($conn, $movimiento, $modulo);

        echo '{"success":true}';
    } else {
        echo '{"error":"Error al actualizar los datos del instructor"}';
    }

    exit;
}

// ❌ Si no es GET ni POST válido
header('Content-Type: application/json');
echo '{"error":"Acceso no permitido"}';
exit;
