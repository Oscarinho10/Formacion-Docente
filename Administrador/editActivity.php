<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Actividad</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">

</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h4 class="text-center mb-3">Edición de actividad formativa</h4>

                <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Nombre actividad -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre_actividad">Nombre de la actividad:</label><br />
                            <input type="text" name="nombre_actividad" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Instructores -->
                        <div class="col-md-4 mb-3">
                            <label for="instructores">Selecciona los instructores:</label><br />
                            <select name="instructores[]" multiple style="width: 100%; padding: 8px; height: 80px;">
                                <option value="1">Juan Perez</option>
                                <option value="2">Juana Teresa</option>
                                <option value="3">Carlos López</option>
                            </select>
                            <small>Puedes seleccionar varios con Ctrl o Cmd</small>
                        </div>

                        <!-- Lugar -->
                        <div class="col-md-4 mb-3">
                            <label for="lugar">Lugar:</label><br />
                            <input type="text" name="lugar" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Dirigido a -->
                        <div class="col-md-4 mb-3">
                            <label for="dirigido_a">Dirigido a:</label><br />
                            <input type="text" name="dirigido_a" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Modalidad -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Modalidad:</label><br />
                            <select name="modalidad" style="width: 100%; padding: 8px;" required>
                                <option value="">Seleccione</option>
                                <option value="linea">En línea</option>
                                <option value="presencial">Presencial</option>
                                <option value="hibrido">Híbrido</option>
                            </select>
                        </div>

                        <!-- Clasificación -->
                        <div class="col-md-4 mb-3">
                            <label for="clasificacion">Clasificación:</label><br />
                            <input type="text" name="clasificacion" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Participantes -->
                        <div class="col-md-4 mb-3">
                            <label for="num_participantes">Número de participantes:</label><br />
                            <input type="text" name="num_participantes" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_participantes">Total participantes:</label><br />
                            <input type="text" name="total_participantes" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_horas">Total de horas:</label><br />
                            <input type="text" name="total_horas" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Fechas con calendario -->
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio">Fecha de inicio:</label><br />
                            <input type="date" name="fecha_inicio" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin">Fecha de fin:</label><br />
                            <input type="date" name="fecha_fin" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Horarios con selector -->
                        <div class="col-md-4 mb-3">
                            <label for="hora_inicio">Hora de inicio:</label><br />
                            <input type="time" name="hora_inicio" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="hora_fin">Hora de fin:</label><br />
                            <input type="time" name="hora_fin" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Archivos -->
                        <div class="col-md-4 mb-3">
                            <label for="temario_pdf">Agregar temario en PDF:</label><br />
                            <input type="file" name="temario_pdf" accept=".pdf" style="width: 100%; padding: 8px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="imagen">Agregar imagen:</label><br />
                            <input type="file" name="imagen" accept="image/*" style="width: 100%; padding: 8px;">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3">
                        <a href="./listActivitys.php" class="btn btn-danger mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-general btn-sm">Registrar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>


</body>

</html>