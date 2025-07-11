<?php
require_once('../../includes/fpdf/fpdf.php');
require_once(dirname(__FILE__) . '/../../config/conexion.php');

if (!$conn) {
    echo "Error de conexión a la base de datos.";
    exit;
}

// Verifica si se envió el id del usuario
$idUsuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

if ($idUsuario <= 0) {
    echo "ID de usuario no proporcionado o inválido.";
    exit;
}

// Datos para control de vista/descarga
$isDownload = isset($_GET['download']) && $_GET['download'] === 'true';

// Consulta de datos del participante y actividad
$sql = "
SELECT 
  u.nombre, 
  u.apellido_paterno, 
  u.apellido_materno,
  u.correo_electronico,
  af.nombre AS nombre_actividad,
  af.fecha_fin, 
  af.total_horas, 
  af.lugar, 
  af.tipo_evaluacion,

  (
    SELECT COUNT(*) 
    FROM asistencias asi
    INNER JOIN sesiones_actividad sa ON asi.id_sesion = sa.id_sesion
    WHERE asi.id_usuario = u.id_usuario
      AND sa.id_actividad = af.id_actividad
      AND asi.presente = true
  ) AS asistencias_validas,

  (
    SELECT COUNT(*) 
    FROM sesiones_actividad sa
    WHERE sa.id_actividad = af.id_actividad
  ) AS total_sesiones,

  (
    SELECT COUNT(*) 
    FROM entregas_actividad ea
    INNER JOIN inscripciones ins2 ON ea.id_inscripcion = ins2.id_inscripcion
    WHERE ins2.id_usuario = u.id_usuario
      AND ins2.id_actividad = af.id_actividad
  ) AS entrego_actividad

FROM usuarios u
INNER JOIN inscripciones i ON i.id_usuario = u.id_usuario
INNER JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
WHERE u.id_usuario = $idUsuario
LIMIT 1;
";

$res = pg_query($conn, $sql);
if (!$res || pg_num_rows($res) == 0) {
    echo "No se encontró la información del participante.";
    exit;
}

$row = pg_fetch_assoc($res);

$porcentaje = 0;
if ($row['total_sesiones'] > 0) {
    $porcentaje = ($row['asistencias_validas'] / $row['total_sesiones']) * 100;
}
$tieneEntrega = $row['entrego_actividad'] > 0;
$tipoConstancia = "";

if ($row['tipo_evaluacion'] == 'actividad') {
    $tipoConstancia = ($porcentaje >= 80 && $tieneEntrega) ? 'ACREDITACIÓN' : 'NO_APLICA';
} else {
    $tipoConstancia = ($porcentaje >= 80) ? 'ASISTENCIA' : 'NO_APLICA';
}

if ($tipoConstancia == 'NO_APLICA') {
    echo "El participante no cumple con los requisitos para una constancia.";
    exit;
}

// Datos finales para el PDF
$nombreCompleto = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
$actividad = $row['nombre_actividad'];
$fechaFin = date("d/m/Y", strtotime($row['fecha_fin']));
$totalHoras = $row['total_horas'];
$lugar = $row['lugar'];

$nombreImagenFondo = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';

$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$pdf->Image($nombreImagenFondo, 0, 0, 280, 216);

// Título
$pdf->SetFont('Arial', 'B', 28);
$pdf->SetTextColor(0, 0, 64);
$pdf->SetXY(0, 45);
$titulo = ($tipoConstancia == 'ACREDITACIÓN') ? 'CONSTANCIA DE PARTICIPACIÓN' : 'CONSTANCIA DE ASISTENCIA';
$pdf->Cell(0, 12, utf8_decode($titulo), 0, 1, 'C');

// Nombre del participante
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(0, 70);
$pdf->Cell(0, 10, utf8_decode($nombreCompleto), 0, 1, 'C');

// Descripción
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(30, 85);
$descripcion = "Por su participación como asistente en el $actividad, impartido con una duración total de $totalHoras horas.";
$pdf->MultiCell(220, 8, utf8_decode($descripcion), 0, 'C');

// Lugar y fecha
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(0, 135);
$pdf->Cell(0, 10, utf8_decode("$lugar, a $fechaFin"), 0, 1, 'C');

// Folio y clave únicos
$pdf->SetFont('Arial', '', 10);
$folio = strtoupper(uniqid('FOLIO'));
$clave = strtoupper(uniqid('CLAVE'));
$pdf->SetXY(15, 185);
$pdf->Cell(0, 6, 'Folio: ' . $folio, 0, 1, 'L');
$pdf->SetX(15);
$pdf->Cell(0, 6, 'Clave: ' . $clave, 0, 1, 'L');

// Código QR
$qrUrl = 'https://docencia.uaem.mx/formacion/PROYECTO/Formacion-Docente/login.php';
$qrApi = 'http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrUrl);
$tempQR = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/temp/temp_qr.png';
if (!file_exists(dirname($tempQR))) mkdir(dirname($tempQR), 0777, true);
file_put_contents($tempQR, file_get_contents($qrApi));
$pdf->Image($tempQR, 235, 155, 30, 30);
unlink($tempQR);

// Nombre del archivo
$nombrepdf = 'constancia_' . strtolower(str_replace(' ', '_', $nombreCompleto)) . '.pdf';

if ($isDownload) {
    $pdf->Output($nombrepdf, 'D'); // Descargar
} else {
    $pdf->Output($nombrepdf, 'I'); // Ver en navegador
}
?>
---

✅ Ahora puedes acceder correctamente con una URL como:

