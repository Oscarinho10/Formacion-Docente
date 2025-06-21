// Datos estáticos de estudiantes (simulados)
const estudiantes = [
  { nombre: "Juan Pérez", correo: "juan@example.com", curso: "Curso de IA" },
  { nombre: "Maria López", correo: "maria@example.com", curso: "Curso de IA" },
  { nombre: "Juana Martinez", correo: "juana@example.com", curso: "Curso de IA" },
  { nombre: "Maria López Perez", correo: "maria.p@example.com", curso: "Curso de Figma" }
];

const rowsPerPage = 2;
let currentPage = 1;

// Función para renderizar la tabla con paginación
function renderTabla() {
  const tableBody = document.getElementById('tableBody');
  const paginationInfo = document.getElementById('paginationInfo');
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const itemsToShow = estudiantes.slice(start, end);

  tableBody.innerHTML = '';

  itemsToShow.forEach(estudiante => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${estudiante.nombre}</td>
      <td>${estudiante.correo}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="generarConstancia('${estudiante.correo}')">Generar</button>
      </td>
    `;
    tableBody.appendChild(row);
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, estudiantes.length)} a ${Math.min(end, estudiantes.length)} de ${estudiantes.length} registros`;

  renderPagination();
}

// Paginación
function renderPagination() {
  const pagination = document.getElementById('pagination');
  const pageCount = Math.ceil(estudiantes.length / rowsPerPage);
  pagination.innerHTML = "";

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

// Generar constancia individual
function generarConstancia(correo) {
  alert(`Generando constancia para: ${correo}`);
  window.location.href = `./controller/generateConstancy.php?correo=${correo}`;
}

// Generar constancias para todos
document.getElementById('generateAllButton').addEventListener('click', function () {
  estudiantes.forEach(est => {
    generarConstancia(est.correo);
  });
});

// Inicializar tabla al cargar
document.addEventListener('DOMContentLoaded', () => {
  renderTabla();
});
