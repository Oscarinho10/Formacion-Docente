<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control = trim($_POST['control']);
    $accion = trim($_POST['accion']);

    if (empty($control) || empty($accion)) {
        echo json_encode(array("success" => false, "error" => "Datos incompletos."));
        exit;
    }

    if ($accion === 'aceptar') {
        $password_default = sha1('default123');
        $query = "UPDATE usuarios 
                  SET estado = 'activo', contrasena = $1 
                  WHERE numero_control_rfc = $2";
        $params = array($password_default, $control);

    } elseif ($accion === 'denegar') {
        $query = "UPDATE usuarios 
                  SET estado = 'rechazado' 
                  WHERE numero_control_rfc = $1";
        $params = array($control);

    } else {
        echo json_encode(array("success" => false, "error" => "Acción inválida."));
        exit;
    }

    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Método no permitido."));
}
