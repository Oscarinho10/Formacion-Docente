<?php
require_once('../../includes/fpdf/fpdf.php');

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Reporte_Por_Actividad_SIGEMFD.pdf"');

class PDF extends FPDF
{
    function Header()
    {
        // Logo izquierdo
        $this->Image('../../assets/img/logo-uaem.png', 10, 6, 25);
        // Logo derecho
        $this->Image('../../assets/img/SIGEM-FD.jpg', 170, 6, 25);

        // Título
        $this->SetFont('Arial', 'B', 14);
        $this->SetY(20);
        $this->Cell(0, 10, utf8_decode('Departamento de Evaluación y Profesionalización de la Docencia'), 0, 1, 'C');

        // Línea separadora
        $this->Ln(2);
        $this->SetDrawColor(0, 102, 153);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function TablaPorAnio($anio, $datos)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode("Año: $anio"), 0, 1, 'L');

        // Encabezados
        $header = array("Unidad Académica", "Actividades", "Participantes", "Asistencias");
        $w = array(80, 35, 35, 35);

        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255);
        $this->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 9);
        $fill = false;

        foreach ($datos as $row) {
            $this->Cell($w[0], 6, utf8_decode($row['unidad']), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['actividades'], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row['participantes'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['asistencias'], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Datos simulados (en producción debes usar $_POST)
$datos = array(
    array("anio" => 2025, "unidad" => "Facultad de Ingeniería", "actividades" => 10, "participantes" => 250, "asistencias" => 240),
    array("anio" => 2024, "unidad" => "Facultad de Ciencias", "actividades" => 8, "participantes" => 200, "asistencias" => 190),
    array("anio" => 2023, "unidad" => "Facultad de Arquitectura", "actividades" => 7, "participantes" => 180, "asistencias" => 175),
    array("anio" => 2022, "unidad" => "Facultad de Humanidades", "actividades" => 5, "participantes" => 150, "asistencias" => 148),
    array("anio" => 2021, "unidad" => "Facultad de Derecho", "actividades" => 6, "participantes" => 160, "asistencias" => 159),
    array("anio" => 2020, "unidad" => "Facultad de Medicina", "actividades" => 4, "participantes" => 120, "asistencias" => 110)
);

// Agrupar por año
$agrupados = array();
foreach ($datos as $row) {
    $anio = $row['anio'];
    if (!isset($agrupados[$anio])) {
        $agrupados[$anio] = array();
    }
    $agrupados[$anio][] = $row;
}
krsort($agrupados); // ordenar descendente por año

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(0, 10, utf8_decode('Reporte por Unidad Académica y Año'), 0, 'C');

foreach ($agrupados as $anio => $lista) {
    $pdf->TablaPorAnio($anio, $lista);
    $pdf->Ln(5);
}

$pdf->Output('I');
