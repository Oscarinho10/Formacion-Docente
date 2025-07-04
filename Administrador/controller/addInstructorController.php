<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');

include_once('../../config/auditor.php');

// Recolectar datos del formulario (compatible con PHP 5.2)
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido_paterno = isset($_POST['apellido_paterno']) ? $_POST['apellido_paterno'] : '';
$apellido_materno = isset($_POST['apellido_materno']) ? $_POST['apellido_materno'] : '';
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '2000-01-01';
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$numero_control = isset($_POST['numero_control']) ? $_POST['numero_control'] : '';
$unidad_academica = isset($_POST['unidad_academica']) ? $_POST['unidad_academica'] : '';
$grado_academico = isset($_POST['grado_academico']) ? $_POST['grado_academico'] : '';
$perfil_academico = isset($_POST['perfil_academico']) ? $_POST['perfil_academico'] : '';
$rol = 'instructor';
$contrasena = sha1('default123');
$estado = 'activo';

// Validación
if (
    $nombre == '' || $apellido_paterno == '' || $apellido_materno == '' ||
    $sexo == '' || $correo == '' || $numero_control == '' ||
    $unidad_academica == '' || $grado_academico == '' || $perfil_academico == ''
) {
    echo "Todos los campos son obligatorios.";
    exit;
}

// Verificar duplicado
$check_query = "SELECT id_usuario FROM usuarios WHERE numero_control_rfc = '" . pg_escape_string($numero_control) . "' OR correo_electronico = '" . pg_escape_string($correo) . "'";
$check_result = pg_query($conn, $check_query);

if ($check_result && pg_num_rows($check_result) > 0) {
    echo "Ya existe un usuario con ese número de control o correo.";
    exit;
}

// Insertar instructor
$query = "INSERT INTO usuarios (
    nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
    correo_electronico, numero_control_rfc, unidad_academica, grado_academico,
    perfil_academico, contrasena, estado, rol
) VALUES (
    '" . pg_escape_string($nombre) . "',
    '" . pg_escape_string($apellido_paterno) . "',
    '" . pg_escape_string($apellido_materno) . "',
    '" . pg_escape_string($fecha_nacimiento) . "',
    '" . pg_escape_string($sexo) . "',
    '" . pg_escape_string($correo) . "',
    '" . pg_escape_string($numero_control) . "',
    '" . pg_escape_string($unidad_academica) . "',
    '" . pg_escape_string($grado_academico) . "',
    '" . pg_escape_string($perfil_academico) . "',
    '" . pg_escape_string($contrasena) . "',
    '" . pg_escape_string($estado) . "',
    '" . pg_escape_string($rol) . "'
)";
$result = pg_query($conn, $query);

if ($result) {
    // ✅ Registrar en auditoría
    $movimiento = "Registró al instructor: $nombre $apellido_paterno $apellido_materno";
    registrarAuditoria($conn, $movimiento, 'Instructores');

    header('Location: ../listInstructors.php');
    exit;
} else {
    echo "Error al registrar instructor: " . pg_last_error($conn);
}
?>
