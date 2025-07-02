<?php
require_once('../../includes/fpdf/fpdf.php');

// Encabezados obligatorios para PDF correcto
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Reporte_Actividades_SIGEMFD.pdf"');

// Obtener los datos del POST (evitar funciones modernas)
$data = array();
if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
}

// Fallback si no vienen datos (modo prueba)
if (!is_array($data) || count($data) == 0) {
    $data = array(
        array(
            "tipo" => "Curso",
            "actividad" => "Liderazgo Organizacional",
            "instructor" => "Dra. Ana Torres",
            "duracion" => "20h",
            "modalidad" => "Presencial",
            "fecha" => "2023-03-15",
            "horario" => "10:00 - 14:00",
            "participantes" => 30,
            "asistidos" => 28
        ),
        array(
            "tipo" => "Taller",
            "actividad" => "Innovación Educativa",
            "instructor" => "Mtro. Luis Rivas",
            "duracion" => "16h",
            "modalidad" => "Virtual",
            "fecha" => "2023-08-01",
            "horario" => "09:00 - 13:00",
            "participantes" => 25,
            "asistidos" => 23
        )
    );
}

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../assets/img/logo-uaem.png', 10, 6, 25);
        $this->Image('../../assets/img/SIGEM-FD.jpg', 170, 6, 25);

        $this->SetFont('Arial', 'B', 14);
        $this->SetY(20);
        $this->Cell(0, 10, utf8_decode('Departamento de Evaluación y Profesionalización de la Docencia'), 0, 1, 'C');

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

    function FancyTable($header, $data)
    {
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 9);

        $w = array(14, 32, 32, 14, 20, 20, 22, 20, 18);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 7);
        $fill = false;

        for ($i = 0; $i < count($data); $i++) {
            $row = $data[$i];
            $this->Cell($w[0], 6, utf8_decode($row['tipo']), 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, utf8_decode($row['actividad']), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, utf8_decode($row['instructor']), 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, utf8_decode($row['duracion']), 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, utf8_decode($row['modalidad']), 'LR', 0, 'C', $fill);
            $this->Cell($w[5], 6, utf8_decode($row['fecha']), 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, utf8_decode($row['horario']), 'LR', 0, 'C', $fill);
            $this->Cell($w[7], 6, $row['participantes'], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, $row['asistidos'], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Título general debajo
$pdf->SetFont('Arial', 'B', 13);
$pdf->Ln(5);
$pdf->MultiCell(0, 10, utf8_decode('Reporte general de actividades del programa SIGEM-FD'), 0, 'C');

$header = array(
    'Tipo', 'Actividad', 'Instructor', 'Duración', 'Modalidad',
    'Fecha inicio', 'Horario', 'Participantes', 'Asistidos'
);

$pdf->FancyTable($header, $data);
$pdf->Output('I', 'Reporte_Actividades_SIGEMFD.pdf');
