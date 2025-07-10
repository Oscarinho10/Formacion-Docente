<?php
date_default_timezone_set('America/Mexico_City');

// Función para registrar una acción del administrador en la tabla auditoria
function registrarAuditoria($conn, $movimiento, $modulo)
{

    if (!isset($_SESSION)) {
        session_start();
    }

    // Solo admins pueden registrar acciones
    if (isset($_SESSION['id_usuario']) && $_SESSION['rol'] == 'admin') {
        $id_admin = $_SESSION['id_usuario'];
        $fecha = date('Y-m-d');       // Ej: 2025-07-03
        $hora = date('H:i:s', strtotime('-1 hour'));

        // Escapar datos para seguridad
        $movimiento_s = pg_escape_string($conn, $movimiento);
        $modulo_s = pg_escape_string($conn, $modulo);

        // Insertar en la tabla auditoria
        $query = "INSERT INTO auditoria (fecha, hora, id_admin, movimiento, modulo)
                  VALUES ('$fecha', '$hora', $id_admin, '$movimiento_s', '$modulo_s')";
        pg_query($conn, $query);
    }
}

// Función para mostrar la fecha en español desde Y-m-d
function formatearFechaEspanol($fecha)
{
    $dias = array(
        'Sunday' => 'Domingo',
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado'
    );

    $meses = array(
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    );

    $timestamp = strtotime($fecha);
    $diaSemanaEn = date('l', $timestamp);
    $mesEn = date('F', $timestamp);
    $dia = date('d', $timestamp);
    $anio = date('Y', $timestamp);

    $diaSemanaEs = $dias[$diaSemanaEn];
    $mesEs = $meses[$mesEn];

    return "$diaSemanaEs $dia de $mesEs del $anio";
}

// Función para mostrar la hora en formato 12h con AM/PM en español
function formatearHoraEspanol($hora24)
{
    $timestamp = strtotime($hora24);
    $hora = date('g:i A', $timestamp); // Ej: "4:25 PM"
    $hora = str_replace('AM', 'a.m.', $hora);
    $hora = str_replace('PM', 'p.m.', $hora);
    return $hora;
}
