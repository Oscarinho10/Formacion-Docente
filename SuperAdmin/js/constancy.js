let data = [];
const rowsPerPage = 5;
let currentPage = 1;
let filteredData = [];

document.addEventListener('DOMContentLoaded', () => {
  const tbody = document.getElementById('tableBody');
  const searchInput = document.getElementById('searchInput');
  const pagination = document.getElementById('pagination');
  const paginationInfo = document.getElementById('paginationInfo');
  const filterFecha = document.getElementById('filterFecha');

  fetch('../SuperAdmin/controller/getConstancyController.php')
    .then(res => res.json())
    .then(json => {
      data = json;
      filteredData = [...data];
      updateTable();
    })
    .catch(err => {
      console.error("Error al cargar constancias:", err);
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
<a href="seeConstancy.php?actividad=${item.id_actividad}&usuario=${item.id_usuario}" class="btn btn-sm btn-general">
  <i class="fas fa-eye"></i> Ver constancia
</a>


        </td>
      </tr>
    `).join('');

    paginationInfo.innerText = `Mostrando ${Math.min(start + 1, dataSet.length)} a ${Math.min(end, dataSet.length)} de ${dataSet.length} registros`;
  }

  function renderPagination(dataSet) {
    pagination.innerHTML = '';
    const pageCount = Math.ceil(dataSet.length / rowsPerPage);

    // «
    const firstLi = document.createElement('li');
    firstLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    firstLi.innerHTML = `<a class="page-link" href="#">«</a>`;
    firstLi.addEventListener('click', e => {
      e.preventDefault();
      if (currentPage > 1) {
        currentPage = 1;
        updateTable();
      }
    });
    pagination.appendChild(firstLi);

    for (let i = 1; i <= pageCount; i++) {
      const li = document.createElement('li');
      li.className = `page-item ${i === currentPage ? 'active' : ''}`;
      li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      li.addEventListener('click', e => {
        e.preventDefault();
        currentPage = i;
        updateTable();
      });
      pagination.appendChild(li);
    }

    // »
    const lastLi = document.createElement('li');
    lastLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
    lastLi.innerHTML = `<a class="page-link" href="#">»</a>`;
    lastLi.addEventListener('click', e => {
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
    const fechaFiltro = filterFecha.value;

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

  searchInput.addEventListener('input', updateTable);
  filterFecha.addEventListener('change', updateTable);

  document.getElementById('clearFiltersBtn').addEventListener('click', function () {
    searchInput.value = '';
    filterFecha.value = '';
    filteredData = [...data];
    currentPage = 1;
    updateTable();
  });
});
