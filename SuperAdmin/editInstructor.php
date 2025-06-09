<?php include('../components/layoutSuper.php') ?>

<div style="width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial; box-sizing: border-box;">
  <h3 style="text-align: center;">Editar Participante</h3>

  <form action="procesar_edicion.php" method="post">
    <input type="hidden" name="id_participante" value="<?php echo $datos['id']; ?>">

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo $datos['nombre']; ?>" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Apellido Paterno</label>
        <input type="text" name="apellido_paterno" class="form-control" value="<?php echo $datos['apellido_paterno']; ?>" required>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Apellido Materno</label>
        <input type="text" name="apellido_materno" class="form-control" value="<?php echo $datos['apellido_materno']; ?>" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Sexo</label>
        <select name="sexo" class="form-control" required>
          <option value="">Seleccione</option>
          <option value="H" <?php if ($datos['sexo'] == 'H') echo 'selected'; ?>>Hombre</option>
          <option value="M" <?php if ($datos['sexo'] == 'M') echo 'selected'; ?>>Mujer</option>
        </select>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Edad</label>
        <input type="number" name="edad" class="form-control" value="<?php echo $datos['edad']; ?>" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Número de Control</label>
        <input type="text" name="numero_control" class="form-control" value="<?php echo $datos['numero_control']; ?>" required>
      </div>
    </div>

    <div style="padding: 10px;">
      <label>Correo Electrónico</label>
      <input type="email" name="correo" class="form-control" value="<?php echo $datos['correo']; ?>" required>
    </div>

    <div style="padding: 10px;">
      <label>Unidad Académica</label>
      <select name="unidad_academica" class="form-control" required>
        <?php
        $unidades = array (
          'Facultad de Ingeniería',
          'Facultad de Ciencias',
          'Facultad de Medicina',
          'Facultad de Derecho',
          'Facultad de Arquitectura'
        );
        foreach ($unidades as $unidad) {
          $selected = $datos['unidad_academica'] == $unidad ? 'selected' : '';
          echo "<option value=\"$unidad\" $selected>$unidad</option>";
        }
        ?>
      </select>
    </div>

    <div style="padding: 10px;">
      <label>Grado Académico</label>
      <select name="grado_academico" class="form-control" required>
        <option value="Licenciatura" <?php if ($datos['grado_academico'] == 'Licenciatura') echo 'selected'; ?>>Licenciatura</option>
        <option value="Maestría" <?php if ($datos['grado_academico'] == 'Maestría') echo 'selected'; ?>>Maestría</option>
        <option value="Doctorado" <?php if ($datos['grado_academico'] == 'Doctorado') echo 'selected'; ?>>Doctorado</option>
      </select>
    </div>

    <div style="text-align: right; padding: 10px;">
      <a href="./instructorSuper.php" class="btn btn-danger" style="margin-right: 10px;">Cancelar</a>
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
  </form>
</div>
