<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../config/verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar participantes</title>

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
                <h4 class="text-center mb-3">
                    Formulario de registro de participantes<br>
                    <strong><?php echo htmlspecialchars($nombre_curso); ?></strong>
                </h4>

                <form action="procesar_inscripcion.php" method="post">
                    <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" style="width: 100%; padding: 8px;" name="nombre" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido_paterno">Apellido Paterno:</label>
                            <input type="text" style="width: 100%; padding: 8px;" name="apellido_paterno" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido_materno">Apellido Materno:</label>
                            <input type="text" style="width: 100%; padding: 8px;" name="apellido_materno" required>
                        </div>

                        <!-- Fecha de nacimiento -->
                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento">Fecha de nacimiento:</label><br />
                            <input type="date" name="fecha_nacimiento" style="width: 100%; padding: 8px;" required
                                min="1930-01-01" max="2025-12-31">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sexo">Sexo:</label>
                            <select style="width: 100%; padding: 11px;" name="sexo" required>
                                <option value="">Seleccione</option>
                                <option value="H">Hombre</option>
                                <option value="M">Mujer</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="correo">Correo electrónico:</label>
                            <input type="email" style="width: 100%; padding: 8px;" name="correo" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="control_rfc">Número de control o RFC:</label>
                            <input type="text" style="width: 100%; padding: 8px;" name="control_rfc" required>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="grado_academico">Grado Académico:</label>
                            <select name="grado_academico" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione grado</option>
                                <option value="Licenciatura">Licenciatura</option>
                                <option value="Maestría">Maestría</option>
                                <option value="Doctorado">Doctorado</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="perfil">Perfil Académico:</label>
                            <select style="width: 100%; padding: 11px;" name="unidadAcaddemica" required>
                                <option value="">Seleccione</option>
                                <option value="M">Docente</option>
                                <option value="D">Doctorado</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="unidad_academica">Unidad Académica:</label>
                            <select style="width: 100%; padding: 11px;" name="unidadAcaddemica" required>
                                <option value="">Seleccione</option>
                                <option value="M">Medicina</option>
                                <option value="D">Derecho</option>
                            </select>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="./listParticipants.php" class="btn btn-danger me-2">Cancelar</a>
                        <button type="submit" class="btn btn-general btn-sm">Registrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>