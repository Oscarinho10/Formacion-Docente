<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $correo = $_POST['correo'];
    $numero_control = $_POST['numero_control'];
    $unidad_academica = $_POST['unidad_academica'];
    $grado_academico = $_POST['grado_academico'];
    $perfil_academico = $_POST['perfil_academico'];
    $estado = 'pendiente';
    $rol = 'participante';
    $fecha_registro = date('Y-m-d');

    // Validar duplicados en la tabla "usuarios"
    $verifica = pg_query_params($conn,
        "SELECT 1 FROM usuarios WHERE correo_electronico = $1 OR numero_control_rfc = $2",
        array($correo, $numero_control)
    );

    if (pg_num_rows($verifica) > 0) {
        echo json_encode(array("success" => false, "error" => "Ya existe un usuario con ese correo o número de control."));
        exit;
    }

    // Obtener último ID (solo si no es serial)
    $id_query = pg_query($conn, "SELECT MAX(id_usuario) FROM usuarios");
    $id_result = pg_fetch_row($id_query);
    $ultimo_id = $id_result[0] ? intval($id_result[0]) : 0;
    $nuevo_id = $ultimo_id + 1;

    // Insertar nuevo usuario
    $query = "INSERT INTO usuarios (
        id_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento,
        sexo, correo_electronico, contrasena, numero_control_rfc,
        unidad_academica, grado_academico, perfil_academico, estado, rol, fecha_registro
    ) VALUES (
        $1, $2, $3, $4, $5,
        $6, $7, '', $8,
        $9, $10, $11, $12, $13, $14
    )";

    $params = array(
        $nuevo_id, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento,
        $sexo, $correo, $numero_control, $unidad_academica,
        $grado_academico, $perfil_academico, $estado, $rol, $fecha_registro
    );

    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo json_encode(array("success" => true, "message" => "Registro exitoso"));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }
}
?>
