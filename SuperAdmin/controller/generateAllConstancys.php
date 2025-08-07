<?php
require_once('../../includes/fpdf/fpdf.php');
require_once('../../config/conexion.php');

$idActividad = isset($_GET['id_actividad']) ? intval($_GET['id_actividad']) : 0;
if ($idActividad <= 0) {
    die("ID de actividad inválido");
}

$sql = "
SELECT 
  u.nombre, u.apellido_paterno, u.apellido_materno, u.correo_electronico,
  af.nombre AS nombre_actividad, af.id_actividad, af.fecha_fin, af.total_horas, af.lugar, af.tipo_evaluacion,
  i.id_inscripcion, i.id_usuario,
  (
    SELECT COUNT(*) FROM asistencias asi
    INNER JOIN sesiones_actividad sa ON asi.id_sesion = sa.id_sesion
    WHERE asi.id_usuario = u.id_usuario AND sa.id_actividad = af.id_actividad AND asi.presente = true
  ) AS asistencias_validas,
  (
    SELECT COUNT(*) FROM sesiones_actividad sa WHERE sa.id_actividad = af.id_actividad
  ) AS total_sesiones,
  (
    SELECT COUNT(*) FROM entregas_actividad ea WHERE ea.id_inscripcion = i.id_inscripcion
  ) AS entrego_actividad
FROM inscripciones i
INNER JOIN usuarios u ON i.id_usuario = u.id_usuario
INNER JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
WHERE i.id_actividad = $idActividad
";

$res = pg_query($conn, $sql);
if (!$res || pg_num_rows($res) == 0) {
    die("No se encontraron participantes.");
}

$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->SetAutoPageBreak(false);
$plantilla = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';
$qrUrlBase = 'https://docencia.uaem.mx/formacion/PROYECTO/Formacion-Docente/login.php';

while ($row = pg_fetch_assoc($res)) {
    $porcentaje = ($row['total_sesiones'] > 0) ? ($row['asistencias_validas'] / $row['total_sesiones']) * 100 : 0;
    $tieneEntrega = $row['entrego_actividad'] > 0;

    if ($row['tipo_evaluacion'] == 'actividad' && ($porcentaje < 80 || !$tieneEntrega)) continue;
    if ($row['tipo_evaluacion'] != 'actividad' && $porcentaje < 80) continue;

    $tipoConstancia = ($row['tipo_evaluacion'] == 'actividad') ? 'ACREDITACIÓN' : 'ASISTENCIA';
    $titulo = ($tipoConstancia == 'ACREDITACIÓN') ? 'CONSTANCIA DE PARTICIPACIÓN' : 'CONSTANCIA DE ASISTENCIA';
    $descripcionTipo = ($tipoConstancia == 'ACREDITACIÓN') ? 'por haber acreditado satisfactoriamente' : 'por su participación como asistente';

    $nombreCompleto = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
    $actividad = $row['nombre_actividad'];
    $fechaFin = date("d/m/Y", strtotime($row['fecha_fin']));
    $totalHoras = $row['total_horas'];
    $lugar = $row['lugar'];

    $folio = strtoupper(uniqid('FOLIO'));
    $clave = strtoupper(uniqid('CLAVE'));
    $qrApi = 'http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrUrlBase);
    $tempQR = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/temp/temp_qr_' . uniqid() . '.png';
    file_put_contents($tempQR, file_get_contents($qrApi));

    $pdf->AddPage();
    $pdf->Image($plantilla, 0, 0, 280, 216);
    $pdf->SetFont('Arial', 'B', 28);
    $pdf->SetXY(0, 45);
    $pdf->Cell(0, 12, utf8_decode($titulo), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetXY(0, 70);
    $pdf->Cell(0, 10, utf8_decode($nombreCompleto), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 14);
    $pdf->SetXY(30, 85);
    $descripcion = "Otorgada $descripcionTipo en el $actividad, impartido con una duración total de $totalHoras horas.";
    $pdf->MultiCell(220, 8, utf8_decode($descripcion), 0, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(0, 135);
    $pdf->Cell(0, 10, utf8_decode("$lugar, a $fechaFin"), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(15, 185);
    $pdf->Cell(0, 6, 'Folio: ' . $folio, 0, 1, 'L');
    $pdf->SetX(15);
    $pdf->Cell(0, 6, 'Clave: ' . $clave, 0, 1, 'L');
    $pdf->Image($tempQR, 235, 155, 30, 30);

    unlink($tempQR);
}

$pdf->Output('constancias_actividad_' . $idActividad . '.pdf', 'I');
