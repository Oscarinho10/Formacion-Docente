<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

include('../components/layoutAdmin.php');
include('../config/conexion.php');

// Obtener ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de actividad inválido.";
    exit;
}

$id = intval($_GET['id']);
$query = pg_query($conn, "SELECT * FROM actividades_formativas WHERE id_actividad = $id");
$actividad = pg_fetch_assoc($query);

if (!$actividad) {
    echo "Actividad no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Actividad</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h4 class="text-center mb-3">Editar actividad formativa</h4>

                <form action="../Administrador/controller/editActivityController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $actividad['id_actividad']; ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nombre">Nombre de la actividad:</label>
                            <input type="text" id="nombre" name="nombre" style="width: 100%; padding: 8px;" value="<?php echo $actividad['nombre']; ?>" required>
                        </div>

                        <!-- Tipo de evaluacion -->
                        <div class="col-md-4 mb-3">
                            <label for="tipo_evaluacion">Tipo de evaluación:</label><br />
                            <select id="tipo_evaluacion" name="tipo_evaluacion" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="asistencias" <?php if ($actividad['tipo_evaluacion'] == 'asistencias') echo 'selected'; ?>>Con asistencias</option>
                                <option value="actividad" <?php if ($actividad['tipo_evaluacion'] == 'actividad') echo 'selected'; ?>>Con entrega de actividades</option>
                            </select>
                        </div>

                        <!-- Clasificación -->
                        <div class="col-md-4 mb-3">
                            <label for="clasificacion">Clasificación:</label><br />
                            <select id="clasificacion" name="clasificacion" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="didáctico-pedagógico" <?php if ($actividad['clasificacion'] == 'didáctico-pedagógico') echo 'selected'; ?>>Didáctico-pedagógico</option>
                                <option value="disciplinar" <?php if ($actividad['clasificacion'] == 'disciplinar') echo 'selected'; ?>>Disciplinar</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descripcion">Descripción de la actividad:</label>
                            <textarea id="descripcion" name="descripcion" style="width: 100%; padding: 12px;" rows="4" required><?php echo $actividad['descripcion']; ?></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="lugar">Lugar:</label>
                            <input type="text" id="lugar" name="lugar" style="width: 100%; padding: 8px;" value="<?php echo $actividad['lugar']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="dirigido_a">Dirigido a:</label>
                            <input type="text" id="dirigido_a" name="dirigido_a" style="width: 100%; padding: 8px;" value="<?php echo $actividad['dirigido_a']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Modalidad:</label>
                            <select id="modalidad" name="modalidad" style="width: 100%; padding: 8px;" required>
                                <option value="">Seleccione</option>
                                <option value="linea" <?php if ($actividad['modalidad'] == 'linea') echo 'selected'; ?>>En línea</option>
                                <option value="presencial" <?php if ($actividad['modalidad'] == 'presencial') echo 'selected'; ?>>Presencial</option>
                                <option value="hibrido" <?php if ($actividad['modalidad'] == 'hibrido') echo 'selected'; ?>>Híbrido</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cupo">Cupo:</label>
                            <input type="text" id="cupo" name="cupo" style="width: 100%; padding: 8px;" value="<?php echo $actividad['cupo']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_horas">Total de horas:</label>
                            <input type="text" id="total_horas" name="total_horas" style="width: 100%; padding: 8px;" value="<?php echo $actividad['total_horas']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio">Fecha de inicio:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" style="width: 100%; padding: 8px;" value="<?php echo $actividad['fecha_inicio']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin">Fecha de fin:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" style="width: 100%; padding: 8px;" value="<?php echo $actividad['fecha_fin']; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="temario_pdf">Temario PDF (opcional):</label>
                            <input type="file" id="temario_pdf" name="temario_pdf" style="width: 100%; padding: 8px;" accept=".pdf">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="url_imagen">Imagen (opcional):</label>
                            <input type="file" id="url_imagen" name="url_imagen" style="width: 100%; padding: 8px;" accept="image/*">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="listActivitys.php" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</a>
                        <button type="submit" class="btn btn-sm btn-general col-2">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
