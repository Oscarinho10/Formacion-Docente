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
    const globalIndex = actividades.indexOf(actividad); // obtiene índice real
    const checked = actividad.estado === "Activo" ? "checked" : "";

    const row = `
      <tr>
        <td>${actividad.nombre}</td>
        <td>${actividad.horas}</td>
        <td class="text-center">
          <label class="switch">
            <input type="checkbox" ${checked} data-index="${globalIndex}" class="estado-toggle">
            <span class="slider"></span>
          </label>
        </td>
        <td class="text-center">
          <button class="btn btn-secondary btn-sm verMasBtn"
                  data-nombre="${actividad.nombre}"
                  data-horas="${actividad.horas}"
                  data-estado="${actividad.estado}"
                  data-bs-toggle="modal"
                  data-bs-target="#modalActividad">
            Ver más
            <i class="fas fa-eye"></i>
          </button>
          <a href="editTrainingActivity.php" class="btn btn-sm btn-general"><i class="fas fa-pen"></i> Editar</a>
        </td>
      </tr>
    `;

    tbody.innerHTML += row;
  });

  const botones = document.querySelectorAll('.verMasBtn');
  botones.forEach(btn => {
    btn.addEventListener('click', function () {
      document.getElementById('modalNombre').innerText = this.dataset.nombre;
      document.getElementById('modalHoras').innerText = this.dataset.horas;
      document.getElementById('modalEstado').innerText = this.dataset.estado;
    });
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, filteredData.length)} a ${Math.min(end, filteredData.length)} de ${filteredData.length} registros`;

  renderPagination();
  addToggleListeners(); // 🔁 LLAMADA AQUÍ DESPUÉS DE GENERAR HTML
}

function renderPagination() {
  const pagination = document.getElementById('pagination');
  const pageCount = Math.ceil(filteredData.length / rowsPerPage);
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

function addToggleListeners() {
  const switches = document.querySelectorAll('.estado-toggle');
  switches.forEach(switchEl => {
    switchEl.addEventListener('change', function () {
      const index = parseInt(this.getAttribute('data-index'));
      const estadoActual = actividades[index].estado;
      const nuevoEstado = (estadoActual === 'Activo') ? 'Inactivo' : 'Activo';

      Swal.fire({
        title: `¿Estás seguro de cambiar el estado?`,
        text: `Actualmente está "${estadoActual}".`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sí, cambiar a "${nuevoEstado}"`,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          actividades[index].estado = nuevoEstado;
          renderTabla(); // actualiza tabla
          Swal.fire({
            title: `¡Estado cambiado!`,
            text: `Ahora está "${nuevoEstado}".`,
            icon: nuevoEstado === "Activo" ? "success" : "warning",
            timer: 1500,
            showConfirmButton: false
          });
        } else {
          this.checked = (estadoActual === 'Activo'); // revierte el toggle
        }
      });
    });
  });
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

  renderTabla(); // inicial
  
});
