<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nombre = pg_escape_string($_POST['nombre']);
    $descripcion = pg_escape_string($_POST['descripcion']);
    $dirigido_a = pg_escape_string($_POST['dirigido_a']);
    $modalidad = pg_escape_string($_POST['modalidad']);
    $lugar = pg_escape_string($_POST['lugar']);
    $clasificacion = pg_escape_string($_POST['clasificacion']);
    $cupo = intval($_POST['cupo']);
    $total_horas = intval($_POST['total_horas']);
    $fecha_inicio = pg_escape_string($_POST['fecha_inicio']);
    $fecha_fin = pg_escape_string($_POST['fecha_fin']);

    $actualizaciones = array();
    $actualizaciones[] = "nombre = '$nombre'";
    $actualizaciones[] = "descripcion = '$descripcion'";
    $actualizaciones[] = "dirigido_a = '$dirigido_a'";
    $actualizaciones[] = "modalidad = '$modalidad'";
    $actualizaciones[] = "lugar = '$lugar'";
    $actualizaciones[] = "clasificacion = '$clasificacion'";
    $actualizaciones[] = "cupo = $cupo";
    $actualizaciones[] = "total_horas = $total_horas";
    $actualizaciones[] = "fecha_inicio = '$fecha_inicio'";
    $actualizaciones[] = "fecha_fin = '$fecha_fin'";

    // Procesar archivo PDF
    if (isset($_FILES['temario_pdf']) && $_FILES['temario_pdf']['error'] == 0) {
        $pdfName = basename($_FILES['temario_pdf']['name']);
        $pdfDir = "../../../uploads/temarios/";
        $pdfPath = $pdfDir . $pdfName;

        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['temario_pdf']['tmp_name'], $pdfPath)) {
            $actualizaciones[] = "temario_pdf = '$pdfName'";
        }
    }

    // Procesar imagen
    if (isset($_FILES['url_imagen']) && $_FILES['url_imagen']['error'] == 0) {
        $imgName = basename($_FILES['url_imagen']['name']);
        $imgDir = "../../../uploads/imagenes/";
        $imgPath = $imgDir . $imgName;

        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['url_imagen']['tmp_name'], $imgPath)) {
            $actualizaciones[] = "url_imagen = '$imgName'";
        }
    }

    $setQuery = implode(", ", $actualizaciones);
    $updateQuery = "UPDATE actividades_formativas SET $setQuery WHERE id_actividad = $id";

    $result = pg_query($conn, $updateQuery);

    if ($result) {
        header("Location: ../trainingActivity.php?edit=ok");
        exit;
    } else {
        echo "Error al actualizar la actividad.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
