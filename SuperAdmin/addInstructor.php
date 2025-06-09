<?php include('../components/layoutSuper.php') ?>

<div style="width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial; box-sizing: border-box;">
  <h3 style="text-align: center;">Agregar Participante</h3>

  <form action="procesar_agregar.php" method="post">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Apellido Paterno</label>
        <input type="text" name="apellido_paterno" class="form-control" required>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Apellido Materno</label>
        <input type="text" name="apellido_materno" class="form-control" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Sexo</label>
        <select name="sexo" class="form-control" required>
          <option value="">Seleccione</option>
          <option value="H">Hombre</option>
          <option value="M">Mujer</option>
        </select>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Edad</label>
        <input type="number" name="edad" class="form-control" required>
      </div>
      <div style="flex: 1; min-width: 250px; padding: 10px;">
        <label>Número de Control</label>
        <input type="text" name="numero_control" class="form-control" required>
      </div>
    </div>

    <div style="padding: 10px;">
      <label>Correo Electrónico</label>
      <input type="email" name="correo" class="form-control" required>
    </div>

    <div style="padding: 10px;">
      <label>Unidad Académica</label>
      <select name="unidad_academica" class="form-control" required>
        <option value="">Seleccione unidad académica</option>
        <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
        <option value="Facultad de Ciencias">Facultad de Ciencias</option>
        <option value="Facultad de Medicina">Facultad de Medicina</option>
        <option value="Facultad de Derecho">Facultad de Derecho</option>
        <option value="Facultad de Arquitectura">Facultad de Arquitectura</option>
      </select>
    </div>

    <div style="padding: 10px;">
      <label>Grado Académico</label>
      <select name="grado_academico" class="form-control" required>
        <option value="">Seleccione grado</option>
        <option value="Licenciatura">Licenciatura</option>
        <option value="Maestría">Maestría</option>
        <option value="Doctorado">Doctorado</option>
      </select>
    </div>

    <div style="text-align: right; padding: 10px;">
      <a href="./instructorSuper.php" class="btn btn-danger" style="margin-right: 10px;">Cancelar</a>
      <button type="submit" class="btn btn-success">Guardar</button>
    </div>
  </form>
</div>
