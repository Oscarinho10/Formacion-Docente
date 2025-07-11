<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');
header('Content-Type: application/json');

// Si es POST: ACEPTAR o DENEGAR participante
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if ($id_usuario == '' || $accion == '') {
        echo json_encode(array("success" => false, "error" => "Datos incompletos."));
        exit;
    }

    // Obtener nombre del participante para auditoría
    $nombreCompleto = 'participante desconocido';
    $resNombre = pg_query($conn, "SELECT nombre, apellido_paterno, apellido_materno FROM usuarios WHERE id_usuario = $id_usuario");
    if ($resNombre && pg_num_rows($resNombre) > 0) {
        $row = pg_fetch_assoc($resNombre);
        $nombreCompleto = trim($row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno']);
    }

    if ($accion == 'aceptar') {
        $password_default = sha1('default123');
        $query = "UPDATE usuarios 
                  SET estado = 'activo', contrasena = $1 
                  WHERE id_usuario = $2";
        $params = array($password_default, $id_usuario);
        $accionTexto = "Aceptó al participante: $nombreCompleto";

    } elseif ($accion == 'denegar') {
        $query = "UPDATE usuarios 
                  SET estado = 'rechazado' 
                  WHERE id_usuario = $1";
        $params = array($id_usuario);
        $accionTexto = "Rechazó al participante: $nombreCompleto";

    } else {
        echo json_encode(array("success" => false, "error" => "Acción inválida."));
        exit;
    }

    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        registrarAuditoria($conn, $accionTexto, 'Usuarios');
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }

// Si es GET: obtener lista de participantes pendientes
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
                     correo_electronico, numero_control_rfc, unidad_academica, grado_academico, 
                     perfil_academico, fecha_registro
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
                "numero_control_rfc" => $row['numero_control_rfc'],
                "unidad_academica" => $row['unidad_academica'],
                "grado_academico" => $row['grado_academico'],
                "perfil_academico" => $row['perfil_academico'],
                "fecha_registro" => $row['fecha_registro']
            );
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }

} else {
    echo json_encode(array("success" => false, "error" => "Método no permitido."));
}
