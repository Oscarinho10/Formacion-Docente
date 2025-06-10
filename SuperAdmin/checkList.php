<?php include('../components/layoutSuper.php'); ?>


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

    <style>
.switch {
  position: relative;
  display: inline-block;
  width: 45px;
  height: 24px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0;
  right: 0; bottom: 0;
  background-color: white;
  border: 2px solid #0B1956;
  border-radius: 34px;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 3px;
  background-color: #0B1956;
  border-radius: 50%;
  transition: .4s;
}
input:checked + .slider {
  background-color: #0B1956;
}
input:checked + .slider:before {
  transform: translateX(20px);
  background-color: white;
}
</style>
</head>

<div class="container mt-4 d-flex justify-content-center">
  <div style="width: 100%; max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Lista de Asistencia </h3>
      <a href="addTrainingActivity.php" class="btn btn-success">Agregar Actividad</a>
    </div>

    <!-- Filtros -->
    <div class="form-row mb-4">
      <div class="col-md-4">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input type="text" id="searchInput" class="form-control" placeholder="Buscar actividad...">
        </div>
      </div>
      <div class="col-md-3">
        <input type="date" id="filterFecha" class="form-control">
      </div>
      <div class="col-md-3">
        <select id="filterEstado" class="form-control">
          <option value="">-- Estado --</option>
          <option value="Activo">Activo</option>
          <option value="Inactivo">Inactivo</option>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-outline-secondary btn-block" id="clearFilters">Limpiar filtros</button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered" id="tablaActividades">
        <thead class="thead-light">
          <tr>
            <th>Nombre de la Actividad</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <!-- Filas dinámicas -->
        </tbody>
      </table>
    </div>

    <!-- Paginador -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="pagination-info" id="paginationInfo"></div>
      <nav>
        <ul class="pagination" id="pagination"></ul>
      </nav>
    </div>
  </div>
</div>

<script>
const data = [
  { nombre: "Curso de Liderazgo", fecha: "2025-06-15", estado: "Activo" },
  { nombre: "Seminario de Innovación", fecha: "2025-07-01", estado: "Inactivo" },
  { nombre: "Curso de Ventas", fecha: "2025-07-10", estado: "Activo" },
  { nombre: "Diplomado de Finanzas", fecha: "2025-08-05", estado: "Activo" },
  { nombre: "Conferencia Marketing", fecha: "2025-08-20", estado: "Inactivo" },
  { nombre: "Taller de Negociación", fecha: "2025-09-15", estado: "Activo" },
  { nombre: "Seminario Legal", fecha: "2025-10-02", estado: "Inactivo" },
  { nombre: "Curso de Diseño", fecha: "2025-10-18", estado: "Activo" }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const fecha = document.getElementById('filterFecha').value;
  const estado = document.getElementById('filterEstado').value;

  filtered = data.filter(item => {
    const matchNombre = item.nombre.toLowerCase().includes(search);
    const matchFecha = !fecha || item.fecha === fecha;
    const matchEstado = !estado || item.estado === estado;
    return matchNombre && matchFecha && matchEstado;
  });

  const totalPages = Math.ceil(filtered.length / rowsPerPage);
  const start = (currentPage - 1) * rowsPerPage;
  const end = Math.min(start + rowsPerPage, filtered.length);
  const visibleData = filtered.slice(start, end);

  document.getElementById('tableBody').innerHTML = visibleData.map(item => `
    <tr>
      <td>${item.nombre}</td>
      <td>${item.fecha}</td>
      <td class="text-center">
        <span class="estado-label">${item.estado}</span>
        <label class="switch ml-2">
          <input type="checkbox" ${item.estado === "Activo" ? "checked" : ""}>
          <span class="slider"></span>
        </label>
      </td>
      <td>
        <a href="listActivity.php" class="btn btn-warning btn-sm">Ver lista</a>
        <a href="participantsList.php" class="btn btn-secondary btn-sm">Participantes</a>
      </td>
    </tr>
  `).join('');

  // Paginador
  document.getElementById('paginationInfo').textContent =
    `Mostrando ${start + 1}-${end} de ${filtered.length} registros`;

  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  if (totalPages > 1) {
    pagination.innerHTML += `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" id="prevPage">&laquo;</a>
      </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
      pagination.innerHTML += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#">${i}</a>
        </li>
      `;
    }

    pagination.innerHTML += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" id="nextPage">&raquo;</a>
      </li>
    `;
  }

  // Eventos paginador
  document.querySelectorAll('#pagination a.page-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const text = e.target.textContent;
      if (text === '«' && currentPage > 1) currentPage--;
      else if (text === '»' && currentPage < totalPages) currentPage++;
      else if (!isNaN(text)) currentPage = parseInt(text);
      renderTable();
    });
  });
}

// Eventos filtros
document.getElementById('searchInput').addEventListener('input', () => {
  currentPage = 1;
  renderTable();
});
document.getElementById('filterFecha').addEventListener('change', () => {
  currentPage = 1;
  renderTable();
});
document.getElementById('filterEstado').addEventListener('change', () => {
  currentPage = 1;
  renderTable();
});
document.getElementById('clearFilters').addEventListener('click', () => {
  document.getElementById('searchInput').value = '';
  document.getElementById('filterFecha').value = '';
  document.getElementById('filterEstado').value = '';
  currentPage = 1;
  renderTable();
});

// Inicializar
document.addEventListener('DOMContentLoaded', renderTable);
</script>