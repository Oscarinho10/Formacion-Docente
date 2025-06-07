<?php
 include('../components/layoutSuper.php')
?>

<div style="width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial; box-sizing: border-box;">
  <h3 style="text-align: center;">Formulario de inscripción de participantes:<br><strong><?php echo htmlspecialchars($nombre_curso); ?></strong></h3>

  <form action="procesar_inscripcion.php" method="post">
    <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="nombre">Nombre</label><br />
        <input type="text" class="form-control" name="nombre" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="apellido_paterno">Apellido Paterno</label><br />
        <input type="text" class="form-control" name="apellido_paterno" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="apellido_materno">Apellido Materno</label><br />
        <input type="text" class="form-control" name="apellido_materno" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="sexo">Sexo</label><br />
        <select class="form-control" name="sexo" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
          <option value="">Seleccione</option>
          <option value="H">Hombre</option>
          <option value="M">Mujer</option>
        </select>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="edad">Edad</label><br />
        <input type="number" class="form-control" name="edad" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="perfil">Perfil Academico</label><br />
        <input type="text" class="form-control" name="perfil" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>
    </div>
    

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="control_rfc">Unidad academica</label><br />
        <input type="text" class="form-control" name="control_rfc" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

       <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="control_rfc">Correo electronico</label><br />
        <input type="text" class="form-control" name="control_rfc" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

       
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="control_rfc">Numero de control o RFC </label><br />
        <input type="text" class="form-control" name="control_rfc" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

   <br>

    <div style="text-align: right; padding: 10px;">
      <a href="./requestSuper.php" type="button" class="btn btn-danger" style="padding: 8px 16px; margin-right: 10px;">Cancelar</a>
      <button type="submit" class="btn btn-success" style="padding: 8px 16px;">Enviar inscripción</button>
    </div>
  </form>
</div>
