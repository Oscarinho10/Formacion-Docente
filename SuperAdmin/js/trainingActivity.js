let actividades = [];
let filteredData = [];
const rowsPerPage = 5;
let currentPage = 1;

async function fetchActividades() {
  try {
    const res = await fetch('../SuperAdmin/controller/listActivitysController.php');
    actividades = await res.json();
    filteredData = [...actividades];
    renderTabla();
  } catch (error) {
    console.error("Error al obtener actividades:", error);
  }
}

function renderTabla() {
  const tbody = document.getElementById('activityTableBody');
  const paginationInfo = document.getElementById('paginationInfo');
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const itemsToShow = filteredData.slice(start, end);

  tbody.innerHTML = "";

  if (itemsToShow.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="4" class="text-center text-muted">No hay actividades registradas.</td>
      </tr>
    `;
    paginationInfo.innerText = `0 registros encontrados.`;
    document.getElementById('pagination').innerHTML = '';
    return;
  }

  itemsToShow.forEach((actividad) => {
    const checked = actividad.estado === "activo" ? "checked" : "";

    const row = `
      <tr>
        <td>${actividad.nombre}</td>
        <td>${actividad.total_horas}</td>
        <td class="text-center">
          <label class="switch">
            <input type="checkbox" ${checked} data-id="${actividad.id}" class="estado-toggle">
            <span class="slider"></span>
          </label>
        </td>
        <td>${actividad.inscritos}/${actividad.cupo}</td>
        <td class="text-center">
          <button class="btn btn-secondary btn-sm verMasBtn"
            data-nombre="${actividad.nombre}"
            data-descripcion="${actividad.descripcion}"
            data-dirigido_a="${actividad.dirigido_a}"
            data-modalidad="${actividad.modalidad}"
            data-lugar="${actividad.lugar}"
            data-clasificacion="${actividad.clasificacion}"
            data-cupo="${actividad.cupo}"
            data-total_horas="${actividad.total_horas}"
            data-estado="${actividad.estado}"
            data-descripcion_horarios="${actividad.descripcion_horarios}"
            data-bs-toggle="modal"
            data-bs-target="#modalActividad">
            Ver más <i class="fas fa-eye"></i>
          </button>
          <a href="editActivity.php?id=${actividad.id}" class="btn btn-sm btn-general">
            <i class="fas fa-pen"></i> Editar
          </a>
          <a href="addSessions.php?id=${actividad.id}" class="btn btn-sm btn-general">
            <i class="fas fa-plus"></i> Agregar sesiones
          </a>
        </td>
      </tr>
    `;

    tbody.innerHTML += row;
  });

  const botones = document.querySelectorAll('.verMasBtn');
  botones.forEach(btn => {
    btn.addEventListener('click', function () {
      document.getElementById('modalNombre').innerText = this.dataset.nombre;
      document.getElementById('modalDescripcion').innerText = this.dataset.descripcion;
      document.getElementById('modalDirigido').innerText = this.dataset.dirigido_a;
      document.getElementById('modalModalidad').innerText = this.dataset.modalidad;
      document.getElementById('modalLugar').innerText = this.dataset.lugar;
      document.getElementById('modalClasificacion').innerText = this.dataset.clasificacion;
      document.getElementById('modalCupo').innerText = this.dataset.cupo;
      document.getElementById('modalHoras').innerText = this.dataset.total_horas;
      document.getElementById('modalEstado').innerText = this.dataset.estado;
      document.getElementById('modalHorarios').innerText = this.dataset.descripcion_horarios;
    });
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, filteredData.length)} a ${Math.min(end, filteredData.length)} de ${filteredData.length} registros`;

  renderPagination();
  addToggleListeners();
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
      const id = this.getAttribute('data-id');
      const actividad = actividades.find(a => a.id == id);
      const estadoActual = actividad.estado;
      const nuevoEstado = (estadoActual === 'activo') ? 'inactivo' : 'activo';

      Swal.fire({
        title: `¿Cambiar estado de la actividad?`,
        text: `Actualmente está "${estadoActual}".`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sí, cambiar a "${nuevoEstado}"`,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#2D882D',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          // Cambiar localmente
          actividad.estado = nuevoEstado;
          renderTabla();
          Swal.fire({
            title: `¡Estado actualizado!`,
            text: `La actividad ahora está "${nuevoEstado}".`,
            icon: nuevoEstado === "activo" ? "success" : "warning",
            timer: 1500,
            showConfirmButton: false
          });

          // TODO: aquí puedes hacer un fetch POST al backend para actualizar en la BD si quieres
        } fetch('../SuperAdmin/controller/updateStateActivityController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `id=${id}&estado=${nuevoEstado}`
        })
          .then(response => response.text())
          .then(data => {
            if (data.trim() !== 'ok') {
              console.error('Error al actualizar en la base de datos:', data);
              Swal.fire('Error', 'No se pudo actualizar el estado en la base de datos.', 'error');
              actividad.estado = estadoActual; // revertimos si falla
              renderTabla();
            }
          })
          .catch(error => {
            console.error('Error en la petición:', error);
            Swal.fire('Error', 'Ocurrió un error en la solicitud.', 'error');
            actividad.estado = estadoActual;
            renderTabla();
          });

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

  fetchActividades();
});
