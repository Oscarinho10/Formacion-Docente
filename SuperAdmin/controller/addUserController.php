<?php
include('../../config/conexion.php');
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener datos del formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido_paterno = isset($_POST['apellido_paterno']) ? $_POST['apellido_paterno'] : '';
$apellido_materno = isset($_POST['apellido_materno']) ? $_POST['apellido_materno'] : '';
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
$correo = isset($_POST['correo_electronico']) ? $_POST['correo_electronico'] : '';
$numero_control = isset($_POST['numero_control']) ? $_POST['numero_control'] : '';
$unidad_academica = isset($_POST['unidad_academica']) ? $_POST['unidad_academica'] : '';
$grado_academico = isset($_POST['grado_academico']) ? $_POST['grado_academico'] : '';
$perfil_academico = isset($_POST['perfil_academico']) ? $_POST['perfil_academico'] : '';

// Validar campos mínimos
if (
    $nombre == '' || $apellido_paterno == '' || $apellido_materno == '' ||
    $fecha_nacimiento == '' || $sexo == '' || $correo == '' ||
    $numero_control == '' || $unidad_academica == '' || $grado_academico == '' || $perfil_academico == ''
) {
    echo json_encode(array("success" => false, "error" => "Todos los campos son obligatorios."));
    exit;
}

// Verificar duplicado
$check = pg_query_params($conn,
    "SELECT id_usuario FROM usuarios WHERE numero_control_rfc = $1 OR correo_electronico = $2",
    array($numero_control, $correo)
);

if ($check && pg_num_rows($check) > 0) {
    echo json_encode(array("success" => false, "error" => "Ya existe un usuario con ese número de control o correo."));
    exit;
}

// Contraseña por defecto
$contrasena = sha1('default123');
$estado = 'activo';
$rol = 'participante'; // Puedes cambiar a 'instructor' u otro rol si lo deseas

// Insertar nuevo usuario
$query = "INSERT INTO usuarios (
    nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
    correo_electronico, numero_control_rfc, unidad_academica, grado_academico,
    perfil_academico, contrasena, estado, rol
) VALUES (
    $1, $2, $3, $4, $5,
    $6, $7, $8, $9,
    $10, $11, $12, $13
)";

$params = array(
    $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $sexo,
    $correo, $numero_control, $unidad_academica, $grado_academico,
    $perfil_academico, $contrasena, $estado, $rol
);

$result = pg_query_params($conn, $query, $params);

if ($result) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
}
