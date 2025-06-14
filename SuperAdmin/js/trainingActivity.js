const actividades = [
  { nombre: "Curso de Liderazgo", horas: 20, estado: "Activo" },
  { nombre: "Seminario de Innovación", horas: 12, estado: "Inactivo" },
  { nombre: "Curso de Comunicación", horas: 16, estado: "Activo" },
  { nombre: "Taller de Creatividad", horas: 10, estado: "Inactivo" },
  { nombre: "Formación Docente", horas: 18, estado: "Activo" },
  { nombre: "Capacitación Técnica", horas: 22, estado: "Inactivo" },
  { nombre: "Planeación Estratégica", horas: 14, estado: "Activo" },
  { nombre: "Curso de Ética Profesional", horas: 15, estado: "Activo" },
  { nombre: "Taller de Oratoria", horas: 8, estado: "Inactivo" },
  { nombre: "Curso de Evaluación", horas: 20, estado: "Activo" }
];

const rowsPerPage = 5;
let currentPage = 1;
let filteredData = [...actividades];

function renderTabla() {
  const tbody = document.getElementById('activityTableBody');
  const paginationInfo = document.getElementById('paginationInfo');
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const itemsToShow = filteredData.slice(start, end);

  tbody.innerHTML = "";
  itemsToShow.forEach((actividad, index) => {
    const checked = actividad.estado === "Activo" ? "checked" : "";
    const row = `
      <tr>
        <td>${actividad.nombre}</td>
        <td>${actividad.horas}</td>
        <td class="text-center">
          <label class="switch">
            <input type="checkbox" ${checked}>
            <span class="slider"></span>
          </label>
        </td>
        <td class="text-center">
          <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas${index + 1}">Ver más</button>
          <a href="editTrainingActivity.php" class="btn btn-sm btn-general">Editar</a>
        </td>
      </tr>
    `;
    tbody.innerHTML += row;
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, filteredData.length)} a ${Math.min(end, filteredData.length)} de ${filteredData.length} registros`;
  renderPagination();
}

function renderPagination() {
  const pagination = document.getElementById('pagination');
  const pageCount = Math.ceil(filteredData.length / rowsPerPage);
  pagination.innerHTML = "";

  // Flecha izquierda
  const prevLi = document.createElement('li');
  prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
  prevLi.innerHTML = `<a class="page-link" href="#">«</a>`;
  prevLi.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage > 1) {
      currentPage--;
      renderTabla();
    }
  });
  pagination.appendChild(prevLi);

  // Números
  for (let i = 1; i <= pageCount; i++) {
    const li = document.createElement('li');
    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    li.addEventListener('click', (e) => {
      e.preventDefault();
      currentPage = i;
      renderTabla();
    });
    pagination.appendChild(li);
  }

  // Flecha derecha
  const nextLi = document.createElement('li');
  nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
  nextLi.innerHTML = `<a class="page-link" href="#">»</a>`;
  nextLi.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage < pageCount) {
      currentPage++;
      renderTabla();
    }
  });
  pagination.appendChild(nextLi);
}

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    filteredData = actividades.filter(a =>
      a.nombre.toLowerCase().includes(query) ||
      a.estado.toLowerCase().includes(query)
    );
    currentPage = 1;
    renderTabla();
  });

  renderTabla();
});
