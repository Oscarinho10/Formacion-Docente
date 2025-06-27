<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if ($id_usuario == '' || $accion == '') {
        echo json_encode(array("success" => false, "error" => "Datos incompletos."));
        exit;
    }

    if ($accion == 'aceptar') {
        $password_default = sha1('default123');
        $query = "UPDATE usuarios 
                  SET estado = 'activo', contrasena = $1 
                  WHERE id_usuario = $2";
        $params = array($password_default, $id_usuario);

    } elseif ($accion == 'denegar') {
        $query = "UPDATE usuarios 
                  SET estado = 'rechazado' 
                  WHERE id_usuario = $1";
        $params = array($id_usuario);

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
