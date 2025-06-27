<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

// Si es POST: ACEPTAR o DENEGAR participante
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    // Validar que existan los datos requeridos
    if ($id_usuario == '' || $accion == '') {
        echo json_encode(array("success" => false, "error" => "Datos incompletos."));
        exit;
    }

    if ($accion == 'aceptar') {
        $password_default = sha1('default123'); // Se asigna contraseña por defecto
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

    // Ejecutar actualización
    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }

// Si es GET: obtener lista de participantes pendientes
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
                     correo_electronico, numero_control_rfc, unidad_academica, grado_academico, 
                     perfil_academico
              FROM usuarios 
              WHERE estado = 'pendiente' AND rol = 'participante'";

    $result = pg_query($conn, $query);
    $datos = array();

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $datos[] = array(
                "id_usuario" => $row['id_usuario'],
                "nombre" => $row['nombre'],
                "apellido_paterno" => $row['apellido_paterno'],
                "apellido_materno" => $row['apellido_materno'],
                "fecha_nacimiento" => $row['fecha_nacimiento'],
                "sexo" => $row['sexo'],
                "correo" => $row['correo_electronico'],
                "numero_control_rfc" => $row['numero_control_rfc'], // ← Renombrado para JS
                "unidad_academica" => $row['unidad_academica'],
                "grado_academico" => $row['grado_academico'],
                "perfil_academico" => $row['perfil_academico']
            );
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }

} else {
    // Otro método HTTP no permitido
    echo json_encode(array("success" => false, "error" => "Método no permitido."));
}
