
<?php
 include('../components/layoutSuper.php')
?>




<head>
    <meta charset="UTF-8">
    <title>Tabla con filtros</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">

</head>


<div class="container mt-4" style="max-width: 1000px;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Asistencias de taller IA</h4>

    <div class="input-group" style="max-width: 250px;">
      <div class="input-group-prepend">
        <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
      </div>
      <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Nombre instructor</th>
          <th>No. control</th>
          <th>Correo electrónico</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        <tr>
          <td>Juan Perez</td>
          <td><strong>45612</strong></td>
          <td>Juanperez@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success">+ Asistencia</button>
          </td>
        </tr>
        <tr>
          <td>Oscar Maydon</td>
          <td><strong>5623</strong></td>
          <td>OscarMaydon@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success">+ Asistencia</button>
          </td>
        </tr>
        <tr>
          <td>Giovanni Pedraza</td>
          <td><strong>568952</strong></td>
          <td>GiovanniPedraza@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success">+ Asistencia</button>
          </td>
        </tr>
        <tr>
          <td>Alejandro Morales</td>
          <td><strong>89567</strong></td>
          <td>AlejandroMorales@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success">+ Asistencia</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    searchInput.addEventListener('input', function () {
      const search = this.value.toLowerCase();
      rows.forEach(row => {
        const match = row.innerText.toLowerCase().includes(search);
        row.style.display = match ? '' : 'none';
      });
    });
  });
</script>
