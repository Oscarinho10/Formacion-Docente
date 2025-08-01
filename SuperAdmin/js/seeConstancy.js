let estudiantes = [];
const rowsPerPage = 5;
let currentPage = 1;

document.addEventListener('DOMContentLoaded', () => {
  fetch('./controller/getParticipantsWithConstancyController.php?id=' + actividadId)
    .then(res => res.json())
    .then(json => {
      estudiantes = json;
      renderTabla();
    })
    .catch(err => {
      console.error("Error al cargar participantes con constancia:", err);
    });

  const btnAll = document.getElementById('generateAllButton');
  if (btnAll) {
    btnAll.addEventListener('click', function () {
      estudiantes.forEach(est => {
        generarConstancia(est.id_inscripcion);
      });
    });
  }

  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      currentPage = 1;
      renderTabla(this.value);
    });
  }
});

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

  if (itemsToShow.length === 0) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="4" class="text-muted">No hay participantes que cumplan con los requisitos para obtener constancia.</td>
      </tr>`;
    paginationInfo.innerText = 'Mostrando 0 de 0 registros';
    renderPagination(0);
    return;
  }

  itemsToShow.forEach(est => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="checkbox" class="chk-estudiante" value="${est.id_inscripcion}"></td>
      <td>${est.nombre}</td>
      <td>${est.correo}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="generarConstancia(${est.id_inscripcion})">
          <i class="fas fa-file-pdf"></i> Generar
        </button>
        ${!est.emitida ? `
        <button class="btn btn-success btn-sm emitir-btn"
                data-id="${est.id_usuario}"
                data-actividad="${actividadId}"
                data-tipo="${est.tipo}">
          <i class="fas fa-check-circle"></i> Emitir
        </button>` : `
        <span class="badge text-bg-warning"><i class="fas fa-check"></i> Emitida</span>
        `}
      </td>
    `;
    tableBody.appendChild(row);
  });

  paginationInfo.innerText = `Mostrando ${Math.min(start + 1, filtrados.length)} a ${Math.min(end, filtrados.length)} de ${filtrados.length} registros`;
  renderPagination(filtrados.length);

  const selectAllCheckbox = document.getElementById('selectAll');
  if (selectAllCheckbox) {
    selectAllCheckbox.onclick = function () {
      const checkboxes = document.querySelectorAll('.chk-estudiante');
      checkboxes.forEach(chk => chk.checked = this.checked);
    };
  }
}

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

function generarConstancia(idInscripcion) {
  window.open(`./controller/generateConstancy.php?id_inscripcion=${idInscripcion}`, "_blank");
}

// ✅ Emitir constancia
document.addEventListener('click', function (e) {
  if (e.target.closest('.emitir-btn')) {
    const btn = e.target.closest('.emitir-btn');
    const idUsuario = btn.dataset.id;
    const idActividad = btn.dataset.actividad;
    const tipoConstancia = btn.dataset.tipo;

    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Se asignará la constancia permanentemente al participante.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, emitir',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#E74B3E",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        const params = 'id_usuario=' + encodeURIComponent(idUsuario) +
          '&id_actividad=' + encodeURIComponent(idActividad) +
          '&tipo=' + encodeURIComponent(tipoConstancia);

        fetch('./controller/sendConstancyController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: params
        })
          .then(function (res) { return res.json(); })
          .then(function (res) {
            if (res.success) {
              Swal.fire('¡Emitida!', 'La constancia ha sido registrada correctamente.', 'success');
              btn.innerHTML = '<i class="fas fa-check"></i> Emitida';
              btn.disabled = true;
              btn.classList.remove('btn-success');
              btn.classList.add('btn-secondary');
            } else {
              Swal.fire('Error', res.message, 'error');
            }
          })
          .catch(function () {
            Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
          });
      }
    });
  }
});
