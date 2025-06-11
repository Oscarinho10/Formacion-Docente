<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Asistencias de taller IA</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

  <!-- FontAwesome -->
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">
  <div class="container mt-4 d-flex justify-content-center">
    <div style="width: 100%; max-width: 1000px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lista de Asistencia</h3>
      </div>

      <!-- Filtros -->
      <div class="form-row mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
          </div>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaAsistencias">
          <thead class="thead-light">
            <tr>
              <th>Nombre Instructor</th>
              <th>No. Control</th>
              <th>Correo Electrónico</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <!-- Paginador -->
      <div class="d-flex justify-content-between align-items-center mt-3">
        <div id="paginationInfo" class="text-muted"></div>
        <ul class="pagination" id="pagination"></ul>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Registrar asistencia</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p id="nombreParticipante" class="font-weight-bold text-primary"></p>
          <input type="text" id="fechaAsistencia" class="form-control mt-2 mb-3" placeholder="Haz clic para elegir fechas" readonly />
          <div id="listaFechasSeleccionadas" class="text-left small text-dark font-weight-bold"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-success" id="guardarAsistencia">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>

  <script>
    const data = [
      { nombre: "Juan Perez", control: "45612", correo: "Juanperez@example.com" },
      { nombre: "Oscar Maydon", control: "5623", correo: "OscarMaydon@example.com" },
      { nombre: "Giovanni Pedraza", control: "568952", correo: "GiovanniPedraza@example.com" },
      { nombre: "Alejandro Morales", control: "89567", correo: "AlejandroMorales@example.com" },
      { nombre: "Diana Ruiz", control: "98712", correo: "DianaRuiz@example.com" },
      { nombre: "Ernesto Torres", control: "65234", correo: "ErnestoTorres@example.com" },
      { nombre: "Carla Romero", control: "47852", correo: "CarlaRomero@example.com" }
    ];

    const rowsPerPage = 5;
    let currentPage = 1;
    let filtered = [...data];
    let nombreActual = '';
    let controlActual = '';

    const picker = new Litepicker({
      element: document.getElementById('fechaAsistencia'),
      format: 'YYYY-MM-DD',
      numberOfMonths: 2,
      numberOfColumns: 2,
      autoApply: true,
      mode: 'multiple'
    });

    picker.on('selected', () => {
      const fechas = picker.selectedDates;
      const lista = document.getElementById('listaFechasSeleccionadas');
      lista.innerHTML = fechas.length
        ? fechas.map(f => new Date(f).toISOString().split('T')[0]).join(', ')
        : '<p>No se ha seleccionado ninguna fecha.</p>';
    });

    function renderTable() {
      const search = document.getElementById('searchInput').value.toLowerCase();
      filtered = data.filter(item => item.nombre.toLowerCase().includes(search));
      const totalPages = Math.ceil(filtered.length / rowsPerPage);
      const start = (currentPage - 1) * rowsPerPage;
      const end = Math.min(start + rowsPerPage, filtered.length);
      const visibleData = filtered.slice(start, end);

      document.getElementById('tableBody').innerHTML = visibleData.map(item => `
        <tr>
          <td>${item.nombre}</td>
          <td><strong>${item.control}</strong></td>
          <td>${item.correo}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-secondary" onclick="alert('Ver más de ${item.nombre}')">Ver más</button>
            <button class="btn btn-sm btn-success" onclick="abrirModal('${item.nombre}', '${item.control}')">+ Asistencia</button>
          </td>
        </tr>
      `).join('');

      document.getElementById('paginationInfo').textContent =
        `Mostrando ${start + 1}-${end} de ${filtered.length} registros`;

      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';

      if (totalPages > 1) {
        pagination.innerHTML += `
          <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="cambiarPagina(currentPage - 1)">&laquo;</a>
          </li>`;

        for (let i = 1; i <= totalPages; i++) {
          pagination.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
              <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
            </li>`;
        }

        pagination.innerHTML += `
          <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="cambiarPagina(currentPage + 1)">&raquo;</a>
          </li>`;
      }
    }

    function cambiarPagina(pag) {
      if (pag >= 1 && pag <= Math.ceil(filtered.length / rowsPerPage)) {
        currentPage = pag;
        renderTable();
      }
    }

    function abrirModal(nombre, control) {
      nombreActual = nombre;
      controlActual = control;
      document.getElementById('nombreParticipante').textContent = `${nombre} (No. Control: ${control})`;
      picker.clearSelection();
      document.getElementById('fechaAsistencia').value = '';
      document.getElementById('listaFechasSeleccionadas').innerHTML = '';
      $('#calendarModal').modal('show');
    }

    document.getElementById('guardarAsistencia').addEventListener('click', () => {
      const fechas = picker.selectedDates;
      if (!fechas || fechas.length === 0) {
        alert("Debes seleccionar al menos una fecha.");
        return;
      }
      const fechasTexto = fechas.map(f => new Date(f).toISOString().split('T')[0]).join(', ');
      console.log("Participante:", nombreActual);
      console.log("Control:", controlActual);
      console.log("Fechas:", fechasTexto);
      alert("Fechas guardadas en consola.");
      $('#calendarModal').modal('hide');
    });

    document.getElementById('searchInput').addEventListener('input', () => {
      currentPage = 1;
      renderTable();
    });

    document.addEventListener('DOMContentLoaded', renderTable);
  </script>
</body>
</html>
