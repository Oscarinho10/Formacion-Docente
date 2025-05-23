<?php

?>

<?php
// (conexión comentada)include './config/conexion.php'; // o 'config/conexion.php' si lo pusiste en una carpeta
// Ya puedes usar $conn aquí para hacer consultas
?>

<?php include './HeadAndFoot/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow-sm p-4">
        <h3>Formulario de pre-resgistro</h3>
        <form method="post" action="procesar_formulario.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <label>Numero de control</label>
                    <input type="text" name="numero_control" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <label>Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <label>Apellido Materno</label>
                    <input type="text" name="apellido_materno" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <label>Perfil académico</label>
                    <select name="perfil_academico" class="form-control">
                        <option value="">Selecciona perfil academico</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="docente">Docente</option>
                        <option value="egresado">Egresado</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Unidad académica</label>
                    <select name="unidad_academica" class="form-control">
                        <option value="">Selecciona unidad academica</option>
                        <option value="ingenieria">Ingeniería</option>
                        <option value="ciencias">Ciencias</option>
                        <option value="letras">Letras</option>
                    </select>
                </div>
            </div>
            <div class="text-end">
                <button type="reset" class="btn btn-secondary">Cancelar</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>



            
        </form>
    </div>
</div>

<?php include './HeadAndFoot/footer.php'; ?>
