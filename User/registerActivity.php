<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'instructor') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layout.php');
include('../User/Controller/activityUserController.php');

?>

<div style="width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial; box-sizing: border-box;">
  <h3 style="text-align: center;">Formulario de inscripción al curso:<br><strong><?php echo htmlspecialchars($nombre_curso); ?></strong></h3>

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
        <label for="perfil">Perfil</label><br />
        <input type="text" class="form-control" name="perfil" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="control_rfc">Número de control / RFC</label><br />
        <input type="text" class="form-control" name="control_rfc" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
      </div>

      <div style="flex: 1; min-width: 250px; padding: 10px; box-sizing: border-box;">
        <label for="grado">Grado académico</label><br />
        <input type="text" class="form-control" value="Licenciatura" disabled style="width: 100%; padding: 8px; box-sizing: border-box;">
      </div>
    </div>

    <div style="text-align: right; padding: 10px;">
      <a href="./ActivityUser.php" type="button" class="btn btn-danger" style="padding: 8px 16px; margin-right: 10px;">Cancelar</a>
      <button type="submit" class="btn btn-success" style="padding: 8px 16px;">Enviar inscripción</button>
    </div>
  </form>
</div>
