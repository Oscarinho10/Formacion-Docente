<?php
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
                <h4 class="text-center mb-3">Registro de actividad formativa</h4>

                <form action="../Administrador/controller/addActivityController.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Nombre actividad -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre">Nombre de la actividad:</label><br />
                            <input type="text" id="nombre" name="nombre" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Descripción de la actividad -->
                        <div class="col-md-12 mb-3">
                            <label for="descripcion">Descripción de la actividad:</label><br />
                            <textarea id="descripcion" name="descripcion" rows="4" style="width: 100%; padding: 12px;" required></textarea>
                        </div>

                        <!-- Lugar -->
                        <div class="col-md-4 mb-3">
                            <label for="lugar">Lugar:</label><br />
                            <input type="text" id="lugar" name="lugar" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Dirigido a -->
                        <div class="col-md-4 mb-3">
                            <label for="dirigido_a">Dirigido a:</label><br />
                            <input type="text" id="dirigido_a" name="dirigido_a" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Modalidad -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Modalidad:</label><br />
                            <select id="modalidad" name="modalidad" style="width: 100%; padding: 8px;" required>
                                <option value="">Seleccione</option>
                                <option value="linea">En línea</option>
                                <option value="presencial">Presencial</option>
                                <option value="hibrido">Híbrido</option>
                            </select>
                        </div>

                        <!-- Clasificación -->
                        <div class="col-md-4 mb-3">
                            <label for="clasificacion">Clasificación:</label><br />
                            <input type="text" id="clasificacion" name="clasificacion" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Participantes -->
                        <div class="col-md-4 mb-3">
                            <label for="cupo">Cupo para participantes:</label><br />
                            <input type="text" id="cupo" name="cupo" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_horas">Total de horas:</label><br />
                            <input type="text" id="total_horas" name="total_horas" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Fechas con calendario -->
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio">Fecha de inicio:</label><br />
                            <input type="date" id="fecha_inicio" name="fecha_inicio" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin">Fecha de fin:</label><br />
                            <input type="date" id="fecha_fin" name="fecha_fin" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Archivos -->
                        <div class="col-md-4 mb-3">
                            <label for="temario_pdf">Agregar temario en PDF:</label><br />
                            <input type="file" id="temario_pdf" name="temario_pdf" accept=".pdf" style="width: 100%; padding: 8px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="url_imagen">Agregar imagen:</label><br />
                            <input type="file" id="url_imagen" name="url_imagen" accept="image/*" style="width: 100%; padding: 8px;">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3">
                        <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listActivitys.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-general col-2">Registrar</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

</body>

</html>