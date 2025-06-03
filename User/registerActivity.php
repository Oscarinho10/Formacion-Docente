<?php
include('../components/layout.php');

$id_actividad = isset($_GET['id']) ? $_GET['id'] : '';
$nombre_curso = isset($_GET['curso']) ? urldecode($_GET['curso']) : '';
?>

<div class="container mt-5">
  <h3>Formulario de inscripción al curso: <strong><?php echo htmlspecialchars($nombre_curso); ?></strong></h3>
  
  <form action="procesar_inscripcion.php" method="post">

    <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" name="nombre" required>
    </div>

    <div class="form-group">
      <label for="apellido_paterno">Apellido Paterno</label>
      <input type="text" class="form-control" name="apellido_paterno" required>
    </div>

    <div class="form-group">
      <label for="apellido_materno">Apellido Materno</label>
      <input type="text" class="form-control" name="apellido_materno" required>
    </div>

    <div class="form-group">
      <label for="sexo">Sexo</label>
      <select class="form-control" name="sexo" required>
        <option value="">Seleccione</option>
        <option value="H">Hombre</option>
        <option value="M">Mujer</option>
      </select>
    </div>

    <div class="form-group">
      <label for="edad">Edad</label>
      <input type="number" class="form-control" name="edad" required>
    </div>

    <div class="form-group">
      <label for="perfil">Perfil</label>
      <input type="text" class="form-control" name="perfil" required>
    </div>

    <div class="form-group">
      <label for="control_rfc">Número de control / RFC</label>
      <input type="text" class="form-control" name="control_rfc" required>
    </div>

    <div class="form-group">
      <label for="grado">Grado académico</label>
      <input type="text" class="form-control" value="Licenciatura" disabled>
    </div>

    <button type="submit" class="btn btn-success">Enviar inscripción</button>
    <a href="tabla_actividades.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
