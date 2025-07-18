<?php
ob_start();
include('../../config/conexion.php');

// ✅ EDITAR (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Importante: evitar uso de json_encode (no disponible en PHP 5.2.0)
    header('Content-Type: application/json');

    $id = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $numero_control_rfc = $_POST['numero_control'];
    $correo = $_POST['correo'];
    $perfil = $_POST['perfil_academico'];
    $unidad = $_POST['unidad_academica'];
    $grado = $_POST['grado_academico'];

    $query = "UPDATE usuarios SET 
                nombre = $1, 
                apellido_paterno = $2, 
                apellido_materno = $3,
                sexo = $4,
                fecha_nacimiento = $5,
                numero_control_rfc = $6,
                correo_electronico = $7,
                perfil_academico = $8,
                unidad_academica = $9,
                grado_academico = $10
              WHERE id_usuario = $11 AND rol = 'instructor'";

    $params = array(
        $nombre, $apellido_paterno, $apellido_materno,
        $sexo, $fecha_nacimiento, $numero_control_rfc, $correo,
        $perfil, $unidad, $grado, $id
    );

    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo '{"success":true}';
    } else {
        echo '{"success":false,"error":"No se pudo actualizar el instructor."}';
    }

    exit;
}

// ✅ PRECARGAR DATOS (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    header('Content-Type: application/json');

    $id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id_usuario = $1 AND rol = 'instructor'";
    $res = pg_query_params($conn, $query, array($id));

    if ($res && pg_num_rows($res) > 0) {
        $row = pg_fetch_assoc($res);

        // Convertir el array manualmente a JSON (porque no hay json_encode)
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

ob_end_flush();
?>
