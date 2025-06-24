const data = [
  { nombre: "Inteligencia artificial", fecha: "2025-06-10", tipo: "Acreditado" },
  { nombre: "Matemáticas", fecha: "2025-06-08", tipo: "Por asistir al curso" },
  { nombre: "Tralalero tralala", fecha: "2025-06-12", tipo: "Acreditado" },
  { nombre: "Diseño de algoritmos", fecha: "2025-05-30", tipo: "Por asistir al curso" },
  { nombre: "Taller de innovación", fecha: "2025-06-01", tipo: "Acreditado" },
  { nombre: "Educación inclusiva", fecha: "2025-06-05", tipo: "Acreditado" },
  { nombre: "Procesamiento de datos", fecha: "2025-06-03", tipo: "Por asistir al curso" },
  { nombre: "Comunicación efectiva", fecha: "2025-05-28", tipo: "Acreditado" }
];

const rowsPerPage = 5;
let currentPage = 1;
let filteredData = [...data];

document.addEventListener('DOMContentLoaded', () => {
  const tbody = document.getElementById('tableBody');
  const searchInput = document.getElementById('searchInput');
  const pagination = document.getElementById('pagination');
  const paginationInfo = document.getElementById('paginationInfo');
  document.getElementById('filterFecha').addEventListener('change', () => {
    updateTable();
  });

  function renderTablePage(dataSet, page) {
    tbody.innerHTML = "";
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = dataSet.slice(start, end);

    tbody.innerHTML = paginatedItems.map(item => `
      <tr>
        <td>${item.nombre}</td>
        <td>${item.fecha}</td>
        <td>${item.tipo}</td>
        <td class="text-center">
          <a href="seeConstancy.php" class="btn btn-sm btn-general"> <i class="fas fa-eye"></i> Ver constancias</a>
        </td>
      </tr>
    `).join('');

    paginationInfo.innerText = `Mostrando ${Math.min(start + 1, dataSet.length)} a ${Math.min(end, dataSet.length)} de ${dataSet.length} registros`;
  }

  function renderPagination(dataSet) {
    pagination.innerHTML = '';
    const pageCount = Math.ceil(dataSet.length / rowsPerPage);

    // Flecha de inicio
    const firstLi = document.createElement('li');
    firstLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    firstLi.innerHTML = `<a class="page-link" href="#">«</a>`;
    firstLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage > 1) {
        currentPage = 1;
        updateTable();
      }
    });
    pagination.appendChild(firstLi);

    // Números de página
    for (let i = 1; i <= pageCount; i++) {
      const li = document.createElement('li');
      li.className = `page-item ${i === currentPage ? 'active' : ''}`;
      li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      li.addEventListener('click', (e) => {
        e.preventDefault();
        currentPage = i;
        updateTable();
      });
      pagination.appendChild(li);
    }

    // Flecha de fin
    const lastLi = document.createElement('li');
    lastLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
    lastLi.innerHTML = `<a class="page-link" href="#">»</a>`;
    lastLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage < pageCount) {
        currentPage = pageCount;
        updateTable();
      }
    });
    pagination.appendChild(lastLi);
  }

  function updateTable() {
    const query = searchInput.value.toLowerCase();
    const fechaFiltro = document.getElementById('filterFecha').value;

    filteredData = data.filter(item => {
      const coincideTexto = item.nombre.toLowerCase().includes(query) ||
        item.fecha.toLowerCase().includes(query) ||
        item.tipo.toLowerCase().includes(query);

      const coincideFecha = fechaFiltro === '' || item.fecha === fechaFiltro;

      return coincideTexto && coincideFecha;
    });

    currentPage = 1;
    renderTablePage(filteredData, currentPage);
    renderPagination(filteredData);
  }

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    filteredData = data.filter(item =>
      item.nombre.toLowerCase().includes(query) ||
      item.fecha.toLowerCase().includes(query) ||
      item.tipo.toLowerCase().includes(query)
    );
    currentPage = 1;
    updateTable();
  });



  updateTable(); // inicial


  // Evento: limpiar filtros
  document.getElementById('clearFiltersBtn').addEventListener('click', function () {
  document.getElementById('searchInput').value = '';
  document.getElementById('filterFecha').value = '';
  filteredData = [...data];
  currentPage = 1;
  updateTable();
});

});
