<?php
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
                <h4 class="text-center mb-3">Registrar Instructor</h4>

                <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre_actividad">Nombre:</label><br />
                            <input type="text" name="nombre_actividad" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Apellido Paterno -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre_actividad">Apellido Paterno:</label><br />
                            <input type="text" name="nombre_actividad" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Apellido Materno -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre_actividad">Apellido Materno:</label><br />
                            <input type="text" name="nombre_actividad" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Fecha de nacimiento -->
                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento">Fecha de nacimiento:</label><br />
                            <input type="date" name="fecha_nacimiento" style="width: 100%; padding: 8px;" required
                                min="1930-01-01" max="2025-12-31">
                        </div>

                        <!-- Sexo -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Sexo:</label><br />
                            <select name="modalidad" style="width: 100%; padding: 12px;" required>
                                <option value="">Seleccione</option>
                                <option value="linea">Masculino</option>
                                <option value="linea">Femenino</option>
                                <option value="hibrido">Prefiero no decirlo</option>
                            </select>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-4 mb-3">
                            <label for="lugar">Correo electrónico:</label><br />
                            <input type="text" name="lugar" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- No. Control -->
                        <div class="col-md-4 mb-3">
                            <label for="dirigido_a">Número de control:</label><br />
                            <input type="text" name="dirigido_a" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Unidad Académica -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Selecciona la Unidad Académica:</label><br />
                            <select name="modalidad" style="width: 100%; padding: 12px;" required>
                                <option value="">Seleccione</option>
                                <option value="Tepetongo">Tepetongo</option>
                                <option value="Chamilpa">Chamilpa</option>
                                <option value="Cuautla">Cuautla</option>
                            </select>
                        </div>

                        <!-- Grado Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Selecciona el Grado Académico:</label><br />
                            <select name="modalidad" style="width: 100%; padding: 12px;" required>
                                <option value="">Seleccione</option>
                                <option value="Licenciado">Licenciado</option>
                                <option value="Ingeniero">Ingeniero</option>
                                <option value="Maestro">Maestro</option>
                            </select>
                        </div>

                        <!-- Perfil Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">Selecciona el Perfil Académico:</label><br />
                            <select name="modalidad" style="width: 100%; padding: 12px;" required>
                                <option value="">Seleccione</option>
                                <option value="Tiempo completo">Tiempo completo</option>
                                <option value="Medio tiempo">Medio tiempo</option>
                                <option value="Maestro">Maestro</option>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end col-12 mb-10 mt-3">
                            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listInstructors.php'" class="btn btn-sm btn-danger mr-3 col-2 py-2">Cancelar</button>
                            <button class="btn btn-sm btn-general col-2">Registrar</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>


</body>

</html>