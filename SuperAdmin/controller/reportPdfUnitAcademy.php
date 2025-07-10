<?php
while (ob_get_level()) ob_end_clean();
ob_start();

require_once('../../includes/fpdf/fpdf.php');

$data = array();

if (isset($_POST['data'])) {
    $json = urldecode($_POST['data']);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        die("Error al procesar datos");
    }
} else {
    die("No se enviaron datos");
}

// Agrupar por año
$agrupado = array();
foreach ($data as $item) {
    $anio = $item['anio'];
    if (!isset($agrupado[$anio])) {
        $agrupado[$anio] = array();
    }
    $agrupado[$anio][] = $item;
}

class PDF extends FPDF
{
    function Header()
    {
        if (file_exists('../../assets/img/logo-uaem.png')) {
            $this->Image('../../assets/img/logo-uaem.png', 10, 6, 25);
        }
        if (file_exists('../../assets/img/SIGEM-FD.jpg')) {
            $this->Image('../../assets/img/SIGEM-FD.jpg', 260, 6, 25);
        }

        $this->SetFont('Arial', 'B', 14);
        $this->SetY(20);
        $this->Cell(0, 10, utf8_decode('Reporte por Unidad Académica'), 0, 1, 'C');
        $this->Ln(3);
        $this->SetDrawColor(0, 102, 153);
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function TablaPorAnio($anio, $datos)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode("Año: ") . $anio, 0, 1, 'L');

        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255);
        $this->Cell(100, 8, 'Unidad Académica', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Actividades', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Participantes', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Asistencias', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Año', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0);
        $fill = false;

        foreach ($datos as $row) {
            $this->Cell(100, 7, utf8_decode($row['unidad']), 1, 0, 'L', $fill);
            $this->Cell(40, 7, $row['actividades'], 1, 0, 'C', $fill);
            $this->Cell(40, 7, $row['participantes'], 1, 0, 'C', $fill);
            $this->Cell(40, 7, $row['asistencias'], 1, 0, 'C', $fill);
            $this->Cell(30, 7, $row['anio'], 1, 1, 'C', $fill);
            $fill = !$fill;
        }

        $this->Ln(5);
    }
}

// Crear PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();

foreach ($agrupado as $anio => $items) {
    $pdf->TablaPorAnio($anio, $items);
}

$pdf->Output('I', 'Reporte_Unidad_Academica_SIGEMFD.pdf');
exit;
