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
      </td>
      <td class="text-center">
        <a href="listAssistsParticipants.php" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ver lista</a>
        <a href="participantsList.php" class="btn btn-sm btn-general">Participantes</a>
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