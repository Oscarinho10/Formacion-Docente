let currentPage = 1;
const rowsPerPage = 5;
let fullData = [];
let fechasGlobales = [];

function cargarAsistencias() {
  const idActividad = new URLSearchParams(window.location.search).get('id');

  fetch(`./controller/participantListController.php?id_actividad=${idActividad}`)
      .then(res => res.json())
    .then(json => {
      fechasGlobales = json.fechas;
      fullData = json.data;

      console.log("Todos los datos:", fullData);
      console.log("Filtrados:", getFilteredData());

      // ✅ Renderizar el encabezado de la tabla con las fechas
      const thead = document.getElementById('theadAsistencias');
      let theadHtml = '<tr><th>Nombre</th>';
      fechasGlobales.forEach(fecha => {
        theadHtml += `<th>${fecha}</th>`;
      });
      theadHtml += '<th>Constancia</th></tr>';
      thead.innerHTML = theadHtml;

      // ✅ Renderizar tabla (sin filtro inicial para evitar errores)
      renderTable(fullData, currentPage);
    })
    .catch(err => {
      console.error("Error al cargar asistencias:", err);
      Swal.fire('Error', 'No se pudo cargar la asistencia.', 'error');
    });
}

function renderTable(data, page = 1) {
  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedData = data.slice(start, end);

  const body = document.getElementById('asistenciaBody');
  body.innerHTML = "";

  if (paginatedData.length === 0) {
    body.innerHTML = `<tr><td colspan="${fechasGlobales.length + 2}" class="text-center">Sin resultados</td></tr>`;
    return;
  }

  paginatedData.forEach(row => {
    let html = `<tr><td>${row.nombre}</td>`;
    fechasGlobales.forEach(fecha => {
      html += `<td>${row.asistencias[fecha]}</td>`;
    });
    html += `<td>${row.constancia}</td></tr>`;
    body.innerHTML += html;
  });

  renderPagination(data.length, page);
}

function renderPagination(totalItems, page) {
  const totalPages = Math.ceil(totalItems / rowsPerPage);
  const pagination = document.getElementById("pagination");
  const paginationInfo = document.getElementById("paginationInfo");

  pagination.innerHTML = "";
  paginationInfo.textContent = `Página ${page} de ${totalPages || 1}`;

  const prev = `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="if(${page}>1) renderTable(getFilteredData(), ${page}-1)">«</a>
                  </li>`;
  pagination.innerHTML += prev;

  for (let i = 1; i <= totalPages; i++) {
    pagination.innerHTML += `<li class="page-item ${i === page ? 'active' : ''}">
            <a class="page-link" href="#" onclick="renderTable(getFilteredData(), ${i})">${i}</a>
        </li>`;
  }

  const next = `<li class="page-item ${page === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="if(${page}<${totalPages}) renderTable(getFilteredData(), ${page}+1)">»</a>
                  </li>`;
  pagination.innerHTML += next;
}

function getFilteredData() {
  const input = document.getElementById('searchInput');
  if (!input || !input.value) return fullData;
  const filtro = input.value.trim().toLowerCase();
  return fullData.filter(d => d.nombre.toLowerCase().includes(filtro));
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('searchInput').addEventListener('input', () => {
    currentPage = 1;
    renderTable(getFilteredData(), currentPage);
  });

  cargarAsistencias();
});
