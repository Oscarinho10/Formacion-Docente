<?php
require_once('../../includes/fpdf/fpdf.php');
require_once(dirname(__FILE__) . '/../../config/conexion.php');

$idUsuario = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;
$idActividad = isset($_GET['id_actividad']) ? (int)$_GET['id_actividad'] : 0;

// Si no hay valores, buscar el primer curso válido que haya impartido
if ($idUsuario <= 0 || $idActividad <= 0) {
    $q = "
        SELECT sa.id_usuario::int AS id_usuario, sa.id_actividad
        FROM sesiones_actividad sa
        LIMIT 1;
    ";
    $r = pg_query($conn, $q);
    if ($r && pg_num_rows($r) > 0) {
        $first = pg_fetch_assoc($r);
        $idUsuario = (int)$first['id_usuario'];
        $idActividad = (int)$first['id_actividad'];
    } else {
        echo "No se encontraron actividades para instructores.";
        exit;
    }
}

// Consulta con datos ya validados
$sql = "
SELECT 
  u.nombre, 
  u.apellido_paterno, 
  u.apellido_materno,
  af.nombre AS nombre_actividad,
  af.id_actividad,
  af.fecha_fin, 
  af.total_horas, 
  af.lugar
FROM sesiones_actividad sa
INNER JOIN usuarios u ON u.id_usuario = sa.id_usuario::int
INNER JOIN actividades_formativas af ON af.id_actividad = sa.id_actividad
WHERE sa.id_usuario::int = $idUsuario AND sa.id_actividad = $idActividad
LIMIT 1;
";

$res = pg_query($conn, $sql);
if (!$res || pg_num_rows($res) == 0) {
    echo "No se encontró la información del instructor.";
    exit;
}

$row = pg_fetch_assoc($res);

$nombreCompleto = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
$actividad = $row['nombre_actividad'];
$fechaFin = date("d/m/Y", strtotime($row['fecha_fin']));
$totalHoras = $row['total_horas'];
$lugar = $row['lugar'];
$titulo = 'CONSTANCIA DE INSTRUCTOR';
$descripcion = "Por su valiosa participación como instructor(a) del $actividad, impartido con una duración total de $totalHoras horas.";

// PDF
$plantilla = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';
$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$pdf->Image($plantilla, 0, 0, 280, 216);

$pdf->SetFont('Arial', 'B', 28);
$pdf->SetTextColor(0, 0, 64);
$pdf->SetXY(0, 45);
$pdf->Cell(0, 12, utf8_decode($titulo), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(0, 70);
$pdf->Cell(0, 10, utf8_decode($nombreCompleto), 0, 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(30, 85);
$pdf->MultiCell(220, 8, utf8_decode($descripcion), 0, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(0, 135);
$pdf->Cell(0, 10, utf8_decode("$lugar, a $fechaFin"), 0, 1, 'C');

$nombrepdf = 'constancia_instructor.pdf';
$pdf->Output($nombrepdf, 'I');
?>
