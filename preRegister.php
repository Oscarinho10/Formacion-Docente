<?php
include('HeadAndFoot/header.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de inscripción</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
</head>

<body class="bg-light">

    <main class="container mt-5">
        <section class="mx-auto" style="max-width: 700px;">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Formulario de inscripción al curso:<br><strong><?php echo htmlspecialchars($nombre_curso); ?></strong></h3>
                    <form action="procesar_inscripcion.php" method="post">
                        <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Número de control / RFC</label>
                                <input type="text" name="control_rfc" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellido_materno" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Sexo</label>
                                <select name="sexo" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Edad</label>
                                <input type="number" name="edad" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Perfil académico</label>
                                <select name="perfil_academico" class="form-control" required>
                                    <option value="">Selecciona perfil</option>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="docente">Docente</option>
                                    <option value="egresado">Egresado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Unidad académica</label>
                                <select name="unidad_academica" class="form-control" required>
                                    <option value="">Selecciona unidad</option>
                                    <option value="ingenieria">Ingeniería</option>
                                    <option value="ciencias">Ciencias</option>
                                    <option value="letras">Letras</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-14">
                            <label>Grado académico</label>
                            <select name="unidad_academica" class="form-control" required>
                                <option value="">Selecciona grado</option>
                                <option value="ingenieria">Ingeniero</option>
                                <option value="ciencias">Doctor</option>
                                <option value="letras">Licenciado</option>
                            </select>
                        </div>
                        <div class="text-right mt-4">
                            <a href="login.php" class="btn btn-danger mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-success">Enviar inscripción</button>
                        </div>

                </div>
                </form>
            </div>
            </div>
        </section>
    </main>

    <?php include('HeadAndFoot/footer.php'); ?>
</body>

</html>