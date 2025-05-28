<?php
// Encabezado
include ('HeadAndFoot/header.php');
?>



<!-- Formulario de pre-registro -->
<div style="width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial; box-sizing: border-box;">
    <h3 style="text-align: center;">Formulario de pre-registro</h3>
    <form method="post" action="procesar_formulario.php">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Nombre</label><br />
                <input type="text" name="nombre" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control" />
            </div>
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Numero de control</label><br />
                <input type="text" name="numero_control" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control" />
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Apellido Paterno</label><br />
                <input type="text" name="apellido_paterno" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control"/>
            </div>
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Apellido Materno</label><br />
                <input type="text" name="apellido_materno" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control" />
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Perfil académico</label><br />
                <select name="perfil_academico" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control">
                    <option value="">Selecciona perfil academico</option>
                    <option value="estudiante">Estudiante</option>
                    <option value="docente">Docente</option>
                    <option value="egresado">Egresado</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
                <label>Unidad académica</label><br />
                <select name="unidad_academica" style="width: 100%; padding: 8px; box-sizing: border-box;" class="form-control">
                    <option value="">Selecciona unidad academica</option>
                    <option value="ingenieria">Ingeniería</option>
                    <option value="ciencias">Ciencias</option>
                    <option value="letras">Letras</option>
                </select>
            </div>
        </div>
        <div style="text-align: right; padding: 10px;">
            <a href="<?php echo BASE_URL;?>/login.php" type="button" class="btn btn-danger" style="padding: 8px 16px; margin-right: 10px;">Cancelar</a>
            <a href="./" type="button" class="btn btn-success" style="padding: 8px 16px;">Enviar</a>
        </div>
    </form>
</div>

<?php
// Pie de página
include ('HeadAndFoot/footer.php');
?>
