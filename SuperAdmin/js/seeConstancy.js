// Datos estáticos de prueba
const estudiantes = [
  { nombre: "Juan Pérez", correo: "juan@example.com", curso: "Curso de IA" },
  { nombre: "Maria López", correo: "maria@example.com", curso: "Curso de IA" },
  { nombre: "Juana Martinez", correo: "juana@example.com", curso: "Curso de IA" },
  { nombre: "Maria López Perez", correo: "maria.p@example.com", curso: "Curso de Figma" }
];

const rowsPerPage = 2;
let currentPage = 1;

// Función principal para renderizar la tabla
function renderTabla(filtro = '') {
  const tableBody = document.getElementById('tableBody');
  const paginationInfo = document.getElementById('paginationInfo');

  const filtrados = estudiantes.filter(est =>
    est.nombre.toLowerCase().includes(filtro.toLowerCase()) ||
    est.correo.toLowerCase().includes(filtro.toLowerCase())
  );

  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const itemsToShow = filtrados.slice(start, end);

  tableBody.innerHTML = '';

  itemsToShow.forEach(est => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="checkbox" class="chk-estudiante" value="${est.correo}"></td>
      <td>${est.nombre}</td>
      <td>${est.correo}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="generarConstancia('${est.correo}')">Generar</button>
      </td>
    `;
    tableBody.appendChild(row);
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, filtrados.length)} a ${Math.min(end, filtrados.length)} de ${filtrados.length} registros`;

  renderPagination(filtrados.length);

  // Reasignar evento a checkbox "Seleccionar todos" después de renderizar
  setTimeout(() => {
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
      selectAllCheckbox.onclick = function () {
        const checkboxes = document.querySelectorAll('.chk-estudiante');
        checkboxes.forEach(chk => chk.checked = this.checked);
      };
    }
  }, 0);
}

// Función de paginación
function renderPagination(totalItems) {
  const pagination = document.getElementById('pagination');
  const pageCount = Math.ceil(totalItems / rowsPerPage);
  pagination.innerHTML = "";

  const prevLi = document.createElement('li');
  prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
  prevLi.innerHTML = `<a class="page-link" href="#">«</a>`;
  prevLi.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage > 1) {
      currentPage--;
      renderTabla(document.getElementById('searchInput').value);
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
      renderTabla(document.getElementById('searchInput').value);
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
      renderTabla(document.getElementById('searchInput').value);
    }
  });
  pagination.appendChild(nextLi);
}

// Función para generar constancia individual
function generarConstancia(correo) {
  alert(`Generando constancia para: ${correo}`);
  window.open(`./controller/generateConstancy.php?correo=${correo}`, "_blank");
}

// Botón: generar constancias de TODOS
document.addEventListener('DOMContentLoaded', () => {
  const btnAll = document.getElementById('generateAllButton');
  if (btnAll) {
    btnAll.addEventListener('click', function () {
      estudiantes.forEach(est => {
        generarConstancia(est.correo);
      });
    });
  }

  const btnSeleccionados = document.getElementById('generateSelectedButton');
  if (btnSeleccionados) {
    btnSeleccionados.addEventListener('click', function () {
      const seleccionados = document.querySelectorAll('.chk-estudiante:checked');
      if (seleccionados.length === 0) {
        alert("Selecciona al menos un participante.");
        return;
      }

      seleccionados.forEach(chk => {
        generarConstancia(chk.value);
      });
    });
  }

  // Búsqueda
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      currentPage = 1;
      renderTabla(this.value);
    });
  }

  renderTabla();
});
