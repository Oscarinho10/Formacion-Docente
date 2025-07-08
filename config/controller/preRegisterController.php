<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $sexo = trim($_POST['sexo']);
    $correo = trim($_POST['correo']);
    $unidad_academica = trim($_POST['unidad_academica']);
    $grado_academico = trim($_POST['grado_academico']);
    $perfil_academico = trim($_POST['perfil_academico']);
    $estado = 'pendiente';
    $rol = 'participante';
    $fecha_registro = date('Y-m-d');

    // Capturar número de control o RFC
    $numero_control = isset($_POST['numero_control']) ? trim($_POST['numero_control']) : '';
    $rfc = isset($_POST['rfc']) ? trim($_POST['rfc']) : '';
    
    if (!empty($numero_control)) {
        $identificador = $numero_control;
    } elseif (!empty($rfc)) {
        $identificador = $rfc;
    } else {
        echo json_encode(array("success" => false, "error" => "Debe proporcionar número de control o RFC."));
        exit;
    }

    // Validar duplicados
    $verifica = pg_query_params($conn,
        "SELECT 1 FROM usuarios WHERE correo_electronico = $1 OR numero_control_rfc = $2",
        array($correo, $identificador)
    );

    if (pg_num_rows($verifica) > 0) {
        echo json_encode(array("success" => false, "error" => "Ya existe un usuario con ese correo o identificador."));
        exit;
    }

    // Obtener nuevo ID
    $id_query = pg_query($conn, "SELECT MAX(id_usuario) FROM usuarios");
    $id_result = pg_fetch_row($id_query);
    $nuevo_id = $id_result[0] ? intval($id_result[0]) + 1 : 1;

    // Contraseña por defecto cifrada (puedes cambiarla)
    $password_plana = '123456';
    $contrasena = sha1($password_plana); // para PHP 5.2.0

    // Insertar nuevo usuario
    $query = "INSERT INTO usuarios (
        id_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento,
        sexo, correo_electronico, contrasena, numero_control_rfc,
        unidad_academica, grado_academico, perfil_academico,
        estado, rol, fecha_registro
    ) VALUES (
        $1, $2, $3, $4, $5,
        $6, $7, $8, $9,
        $10, $11, $12,
        $13, $14, $15
    )";

    $params = array(
        $nuevo_id, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento,
        $sexo, $correo, $contrasena, $identificador,
        $unidad_academica, $grado_academico, $perfil_academico,
        $estado, $rol, $fecha_registro
    );

    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo json_encode(array("success" => true, "message" => "Registro exitoso"));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }
}
?>
