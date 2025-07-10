let actividades = [];
let filtered = [];
const rowsPerPage = 5;
let currentPage = 1;

async function fetchActividades() {
  try {
    const res = await fetch('../Administrador/controller/listActivitysController.php');
    actividades = await res.json();
    filtered = [...actividades];
    renderTable();
  } catch (error) {
    console.error("Error al obtener actividades:", error);
  }
}

function renderTable() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const fecha = document.getElementById('filterFecha').value;
  const fechaI = document.getElementById('filterFecha').value;
  const estado = document.getElementById('filterEstado').value;

  filtered = actividades.filter(item => {
    const matchNombre = item.nombre.toLowerCase().includes(search);
    const matchFecha = !fecha || item.fecha_fin === fecha;
    const matchFechaI = !fechaI || item.fecha_inicio === fechaI;
    const matchEstado = !estado || item.estado === estado;
    return matchNombre && matchFecha && matchEstado && matchFechaI;
  });

  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const visibleData = filtered.slice(start, end);

  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = visibleData.map(item => `
    <tr>
      <td>${item.nombre}</td>
      <td>${item.fecha_inicio} / ${item.fecha_fin}</td>
      
      <td class="text-center">
        <span class="estado-label">${item.estado}</span>
      </td>
      <td>${item.tipo_evaluacion}
      <td>
        <a href="listActivity.php?id=${item.id}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ver lista</a>
        <a href="participantsList.php?id=${item.id}" class="btn btn-sm btn-general">Participantes</a>
      </td>
    </tr>
  `).join('');

  // Paginación
  const totalPages = Math.ceil(filtered.length / rowsPerPage);
  const pagination = document.getElementById('pagination');
  document.getElementById('paginationInfo').textContent = 
    `Mostrando ${filtered.length === 0 ? 0 : (start + 1)}-${Math.min(end, filtered.length)} de ${filtered.length} registros`;

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

// Inicializar datos dinámicos
document.addEventListener('DOMContentLoaded', fetchActividades);
