<?php include('../components/layoutSuper.php') ?>

<head>
  <meta charset="UTF-8">
  <title>Tabla con filtros</title>

  <!-- CSS Bootstrap y tabla -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">

  <!-- Litepicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
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
        <tr data-nombre="Juan Perez" data-control="45612">
          <td>Juan Perez</td>
          <td><strong>45612</strong></td>
          <td>Juanperez@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success btn-asistencia">+ Asistencia</button>
          </td>
        </tr>
        <tr data-nombre="Oscar Maydon" data-control="5623">
          <td>Oscar Maydon</td>
          <td><strong>5623</strong></td>
          <td>OscarMaydon@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success btn-asistencia">+ Asistencia</button>
          </td>
        </tr>
        <tr data-nombre="Giovanni Pedraza" data-control="568952">
          <td>Giovanni Pedraza</td>
          <td><strong>568952</strong></td>
          <td>GiovanniPedraza@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success btn-asistencia">+ Asistencia</button>
          </td>
        </tr>
        <tr data-nombre="Alejandro Morales" data-control="89567">
          <td>Alejandro Morales</td>
          <td><strong>89567</strong></td>
          <td>AlejandroMorales@example.com</td>
          <td class="text-center acciones">
            <button class="btn btn-sm btn-light">Ver más</button>
            <button class="btn btn-sm btn-success btn-asistencia">+ Asistencia</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="calendarModalLabel">Registrar asistencia</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p id="nombreParticipante" class="font-weight-bold mb-2 text-primary"></p>
        <label for="fechaAsistencia">Selecciona los días de asistencia:</label>
        <input type="text" id="fechaAsistencia" class="form-control mt-2 mb-3" placeholder="Haz clic para elegir fechas" readonly />
        <div id="listaFechasSeleccionadas" class="text-left small text-dark font-weight-bold"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="guardarAsistencia">Guardar (futuro)</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    let nombreActual = '';
    let controlActual = '';

    // Búsqueda
    searchInput.addEventListener('input', function () {
      const search = this.value.toLowerCase();
      rows.forEach(row => {
        const match = row.innerText.toLowerCase().includes(search);
        row.style.display = match ? '' : 'none';
      });
    });

    // Inicializa Litepicker
    const picker = new Litepicker({
      element: document.getElementById('fechaAsistencia'),
      format: 'YYYY-MM-DD',
      numberOfMonths: 2,
      numberOfColumns: 2,
      autoApply: true,
      mode: 'multiple'
    });

    // Mostrar fechas separadas por comas
    picker.on('selected', () => {
      const fechas = picker.selectedDates;
      const contenedor = document.getElementById('listaFechasSeleccionadas');
      contenedor.innerHTML = '';

      if (!fechas || fechas.length === 0) {
        contenedor.innerHTML = '<p>No se ha seleccionado ninguna fecha.</p>';
        return;
      }

      const fechasTexto = fechas.map(d => {
        return new Date(d).toISOString().split('T')[0];
      }).join(', ');

      contenedor.textContent = fechasTexto;
    });

    // Al hacer clic en "+ Asistencia"
    document.querySelectorAll('.btn-asistencia').forEach(btn => {
      btn.addEventListener('click', function () {
        const row = this.closest('tr');
        nombreActual = row.getAttribute('data-nombre');
        controlActual = row.getAttribute('data-control');

        document.getElementById('nombreParticipante').textContent = `${nombreActual} (No. Control: ${controlActual})`;
        picker.clearSelection();
        document.getElementById('fechaAsistencia').value = '';
        document.getElementById('listaFechasSeleccionadas').innerHTML = '';

        $('#calendarModal').modal('show');
      });
    });

    // Guardar (por ahora en consola)
    document.getElementById('guardarAsistencia').addEventListener('click', function () {
      const fechas = picker.selectedDates;

      if (!fechas || fechas.length === 0) {
        alert("Debes seleccionar al menos una fecha.");
        return;
      }

      const fechasTexto = fechas.map(d => {
        return new Date(d).toISOString().split('T')[0];
      }).join(', ');

      console.log("Participante:", nombreActual);
      console.log("No. Control:", controlActual);
      console.log("Fechas seleccionadas:", fechasTexto);

      alert("Fechas guardadas en consola.");
      $('#calendarModal').modal('hide');
    });
  });
</script>
