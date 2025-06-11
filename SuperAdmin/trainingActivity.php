<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Lista de Actividades</title>

  <!-- Estilos -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">

 
</head>

<body class="bg-light">
  <div class="container mt-4">
    <h4 class="mb-3">Lista de Actividades</h4>

    <!-- Botón agregar -->
    <div class="d-flex justify-content-end mb-3">
      <a href="addTrainingActivity.php" class="btn btn-primary">+ Agregar Actividad</a>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered ">
        <thead class="thead-light">
          <tr>
            <th>Nombre de la Actividad</th>
            <th>Total de Horas</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Curso de Liderazgo</td>
            <td>20</td>
            <td class="text-center">
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </td>
            <td class="text-center">
              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas1">Ver más</button>
              <a href="editTrainingActivity.php" class="btn btn-sm btn-general">Editar</a>
            </td>
          </tr>
          <tr>
            <td>Seminario de Innovación</td>
            <td>12</td>
            <td class="text-center">
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </td>
            <td class="text-center">
              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas2">Ver más</button>
              <a href="editTrainingActivity.php" class="btn btn-sm btn-general">Editar</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bootstrap JS (si estás usando funcionalidades como modal o toggle) -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
</body>

</html>
