<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');

include_once('../../config/auditor.php'); // Para registrar auditoría

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
    $nuevoEstado = isset($_POST['estado']) ? $_POST['estado'] : '';

    if ($id_actividad > 0 && ($nuevoEstado === 'activo' || $nuevoEstado === 'inactivo')) {
        $query = "UPDATE actividades_formativas SET estado = '$nuevoEstado' WHERE id_actividad = $id_actividad";
        $result = pg_query($conn, $query);

        if ($result) {
            // ✅ Obtener nombre de la actividad para auditoría
            $res_nombre = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
            $nombre_act = ($res_nombre && pg_num_rows($res_nombre) > 0) ? pg_fetch_result($res_nombre, 0, 'nombre') : '';

            // Registrar en auditoría
            $movimiento = "Cambió el estado de la actividad \"$nombre_act\" (ID $id_actividad) a '$nuevoEstado'";
            $modulo = "Actividades formativas";
            registrarAuditoria($conn, $movimiento, $modulo);

            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => 'Error al actualizar en la base de datos.'));
        }
    } else {
        echo json_encode(array('success' => false, 'error' => 'Datos inválidos.'));
    }
} else {
    echo json_encode(array('success' => false, 'error' => 'Método no permitido.'));
}
?>
