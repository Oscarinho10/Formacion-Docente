<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Instructor</title>
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
                <h4 class="text-center mb-3">Agregar Instructor</h4>

                <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-4 mb-3">
                            <label for="nombre" >Nombre</label>
                            <input type="text" name="nombre" id="nombre" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Apellido Paterno -->
                        <div class="col-md-4 mb-3">
                            <label for="apellido_paterno">Apellido Paterno:</label><br />
                            <input type="text" name="apellido_paterno" id="apellido_paterno" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Apellido Materno -->
                        <div class="col-md-4 mb-3">
                            <label for="apellido_materno">Apellido Materno:</label><br />
                            <input type="text" name="apellido_materno" id="apellido_materno" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Fecha de nacimiento -->
                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento">Fecha de nacimiento:</label><br />
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" style="width: 100%; padding: 8px;" required
                                min="1930-01-01" max="2025-12-31">
                        </div>

                        <!-- Sexo -->
                        <div class="col-md-4 mb-3">
                            <label for="sexo">Sexo:</label><br />
                            <select name="sexo" id="sexo" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Prefiero no decirlo</option>
                            </select>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-4 mb-3">
                            <label for="correo">Correo electrónico:</label><br />
                            <input type="text" name="correo" id="correo" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- No. Control -->
                        <div class="col-md-4 mb-3">
                            <label for="numero_control">Número de control:</label><br />
                            <input type="text" name="numero_control" id="numero_control" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Grado Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="grado_academico">Grado Académico:</label><br />
                            <select name="grado_academico" id="grado_academico" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="N/A">No aplica</option>
                                <option value="Licenciado">Licenciado</option>
                                <option value="Ingeniero">Ingeniero</option>
                                <option value="Maestro">Maestro</option>
                            </select>
                        </div>

                        <!-- Perfil Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="perfil_academico">Perfil Académico:</label><br />
                            <select name="perfil_academico" id="perfil_academico" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="N/A">No aplica</option>
                                <option value="Tiempo completo">Tiempo completo</option>
                                <option value="Medio tiempo">Medio tiempo</option>
                                <option value="Maestro">Maestro</option>
                            </select>
                        </div>

                        <!-- Unidad Académica -->
                        <div class="col-md-4 mb-3">
                            <label for="unidad_academica">Unidad Académica:</label><br />
                            <select name="unidad_academica" id="unidad_academica" style="width: 322%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="N/A">No aplica</option>
                                <option value="Tepetongo">Tepetongo</option>
                                <option value="Chamilpa">Chamilpa</option>
                                <option value="Cuautla">Cuautla</option>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end col-12 mb-10 mt-3">
                            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listInstructors.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</button>
                            <button type="submit" class="btn btn-sm btn-general col-2">Registrar</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

    <!-- Scripts necesarios -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/addInstructor.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>