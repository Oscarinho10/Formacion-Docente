<?php include('../components/layoutSuper.php'); ?>
<div style="width: 95%; max-width: 1000px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif; box-sizing: border-box;">
  <h3 style="text-align: center;">Formulario para agregar nueva actividad</h3>

  <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <!-- Nombre actividad -->
      <div style="flex: 1 1 100%; padding: 10px;">
        <label for="nombre_actividad">Nombre de la actividad:</label><br />
        <input type="text" name="nombre_actividad" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Instructores -->
      <div style="flex: 1 1 100%; padding: 10px;">
        <label for="instructores">Selecciona los instructores:</label><br />
        <select name="instructores[]" multiple style="width: 100%; padding: 8px; height: 80px;">
          <option value="1">Juan Perez</option>
          <option value="2">Juana Teresa</option>
          <option value="3">Carlos López</option>
        </select>
        <small>Puedes seleccionar varios con Ctrl o Cmd</small>
      </div>

      <!-- Lugar -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="lugar">Lugar:</label><br />
        <input type="text" name="lugar" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Dirigido a -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="dirigido_a">Dirigido a:</label><br />
        <input type="text" name="dirigido_a" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Modalidad -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="modalidad">Modalidad:</label><br />
        <select name="modalidad" style="width: 100%; padding: 8px;" required>
          <option value="">Seleccione</option>
          <option value="linea">En línea</option>
          <option value="presencial">Presencial</option>
          <option value="hibrido">Híbrido</option>
        </select>
      </div>

      <!-- Clasificación -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="clasificacion">Clasificación:</label><br />
        <input type="text" name="clasificacion" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Participantes -->
      <div style="flex: 1 1 30%; padding: 10px;">
        <label for="num_participantes">Número de participantes:</label><br />
        <input type="text" name="num_participantes" style="width: 100%; padding: 8px;" required>
      </div>

      <div style="flex: 1 1 30%; padding: 10px;">
        <label for="total_participantes">Total participantes:</label><br />
        <input type="text" name="total_participantes" style="width: 100%; padding: 8px;" required>
      </div>

      <div style="flex: 1 1 30%; padding: 10px;">
        <label for="total_horas">Total de horas:</label><br />
        <input type="text" name="total_horas" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Fechas -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="fecha_inicio">Fecha de inicio (YYYY-MM-DD):</label><br />
        <input type="text" name="fecha_inicio" style="width: 100%; padding: 8px;" required>
      </div>

      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="fecha_fin">Fecha de fin (YYYY-MM-DD):</label><br />
        <input type="text" name="fecha_fin" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Horas -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="hora_inicio">Hora de inicio (HH:MM):</label><br />
        <input type="text" name="hora_inicio" style="width: 100%; padding: 8px;" required>
      </div>

      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="hora_fin">Hora de fin (HH:MM):</label><br />
        <input type="text" name="hora_fin" style="width: 100%; padding: 8px;" required>
      </div>

      <!-- Subir temario PDF -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="temario_pdf">Agregar temario en PDF:</label><br />
        <input type="file" name="temario_pdf" accept=".pdf" style="width: 100%; padding: 8px;">
      </div>

      <!-- Subir imagen -->
      <div style="flex: 1 1 45%; padding: 10px;">
        <label for="imagen">Agregar imagen:</label><br />
        <input type="file" name="imagen" accept="image/*" style="width: 100%; padding: 8px;">
      </div>
    </div>

    <!-- Botones -->
    <div style="text-align: right; padding: 10px;">
      <a href="./trainingActivity.php" class="btn btn-secondary" style="padding: 8px 16px; background-color: #999; color: white; text-decoration: none;">Cancelar</a>
      <button type="submit" class="btn btn-primary" style="padding: 8px 16px; background-color: #28a745; color: white;">Guardar actividad</button>
    </div>
  </form>
</div>
