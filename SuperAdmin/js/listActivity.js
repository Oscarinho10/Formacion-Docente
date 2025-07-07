const rowsPerPage = 5;
let currentPage = 1;
let data = [];
let filtered = [];

async function fetchParticipantes() {
  const urlParams = new URLSearchParams(window.location.search);
  const idActividad = urlParams.get('id');

  if (!idActividad) {
    alert("No se proporcionó ID de actividad.");
    return;
  }

  try {
    const res = await fetch(`../SuperAdmin/controller/getParticipantsForActivity.php?id=${idActividad}`);
    data = await res.json();
    filtered = [...data];
    renderTable();
  } catch (error) {
    console.error("Error al cargar participantes:", error);
  }
}

function renderTable() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  filtered = data.filter(item => item.nombre.toLowerCase().includes(search));
  const totalPages = Math.ceil(filtered.length / rowsPerPage);
  const start = (currentPage - 1) * rowsPerPage;
  const end = Math.min(start + rowsPerPage, filtered.length);
  const visibleData = filtered.slice(start, end);

  // ✅ Si no hay resultados
  if (filtered.length === 0) {
    $('#tableBody').html(`
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    No hay participantes registrados en esta actividad por el momento.
                </td>
            </tr>
        `);
    $('#pagination').html('');
    return;
  }

  document.getElementById('tableBody').innerHTML = visibleData.map(item => `
    <tr>
      <td>${item.nombre} ${item.apellido_paterno} ${item.apellido_materno}</td>
      <td><strong>${item.control}</strong></td>
      <td>${item.correo}</td>
      <td class="text-center">
        <button class="btn btn-secondary btn-sm verMasBtn"
                data-nombre="${item.nombre}"
                data-apellido-paterno="${item.apellido_paterno}"
                data-apellido-materno="${item.apellido_materno}"
                data-fecha="${item.fecha_nacimiento}"
                data-sexo="${item.sexo}"
                data-unidad="${item.unidad_academica}"
                data-grado="${item.grado_academico}"
                data-correo="${item.correo}"
                data-perfil="${item.perfil_academico}"
                data-fecha-registro="${item.fecha_registro}"
                data-bs-toggle="modal"
                data-bs-target="#modalParticipants">
                Ver más <i class="fas fa-eye"></i>
        </button>
        <button class="btn btn-sm btn-success btnAsistencia"
                data-id="${item.id_usuario}"  
                data-control="${item.control}"
                data-nombre="${item.nombre}"
                data-apellido_paterno="${item.apellido_paterno}"
                data-apellido_materno="${item.apellido_materno}"
                data-bs-toggle="modal"
                data-bs-target="#modalAsistencia">
          <i class="fas fa-calendar-check"></i> Asistencia
        </button>
      </td>
    </tr>
  `).join('');

  document.getElementById('paginationInfo').textContent =
    `Mostrando ${start + 1}-${end} de ${filtered.length} registros`;

  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  if (totalPages > 1) {
    pagination.innerHTML += `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage - 1})">&laquo;</a>
      </li>`;
    for (let i = 1; i <= totalPages; i++) {
      pagination.innerHTML += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
        </li>`;
    }
    pagination.innerHTML += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage + 1})">&raquo;</a>
      </li>`;
  }
}

function cambiarPagina(pag) {
  if (pag >= 1 && pag <= Math.ceil(filtered.length / rowsPerPage)) {
    currentPage = pag;
    renderTable();
  }
}

$(document).ready(function () {
  fetchParticipantes();

  $('#searchInput').on('input', function () {
    currentPage = 1;
    renderTable();
  });

  $(document).on('click', '.verMasBtn', function () {
    const nombre = $(this).data('nombre');
    const paterno = $(this).data('apellido_paterno');
    const materno = $(this).data('apellido_materno');
    const fecha = $(this).data('fecha');
    const sexo = $(this).data('sexo');
    const correo = $(this).data('correo');
    const unidad = $(this).data('unidad');
    const grado = $(this).data('grado');
    const perfil = $(this).data('perfil');
    const fecha_registro = $(this).data('fecha-registro');

    $('#modalNombreCompleto').text(`${nombre} ${paterno} ${materno}`);
    $('#modalFecha').text(fecha);
    $('#modalSexo').text(sexo);
    $('#modalCorreo').text(correo);
    $('#modalUnidad').text(unidad);
    $('#modalGrado').text(grado);
    $('#modalPerfil').text(perfil);
    $('#modalFechaRegistro').text(fecha_registro);
  });
});

// ASISTENCIA
$(document).on('click', '.btnAsistencia', function () {
  const idUsuario = $(this).data('id');
  const nombre = $(this).data('nombre');
  const paterno = $(this).data('apellido_paterno');
  const materno = $(this).data('apellido_materno');
  $('#nombreParticipanteAsistencia').text(`${nombre} ${paterno} ${materno}`);
  const idActividad = new URLSearchParams(window.location.search).get('id');

  // Obtener sesiones
  fetch(`../SuperAdmin/controller/getSessionsActivity.php?id=${idActividad}&id_usuario=${idUsuario}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('tablaSesionesAsistencia');
      tbody.innerHTML = '';

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="3" class="text-center text-muted">No hay sesiones para esta actividad.</td>
          </tr>`;
        return;
      }

      data.forEach(sesion => {
        const checked = sesion.asistio == 1 ? 'checked' : '';
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${sesion.fecha}</td>
          <td>${sesion.nombre_sesion}</td>
          <td class="text-center">
            <input type="checkbox" class="checkAsistencia" data-id-sesion="${sesion.id_sesion}" ${checked}>
          </td>
        `;
        tbody.appendChild(fila);

      });

      $('#guardarAsistenciaBtn').off('click').on('click', function () {
        const asistencias = [];
        document.querySelectorAll('.checkAsistencia').forEach(chk => {
          asistencias.push({
            id_sesion: parseInt(chk.dataset.idSesion),
            presente: chk.checked
          });
        });


        fetch('../SuperAdmin/controller/saveAssist.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            id_usuario: idUsuario,
            asistencias: asistencias // ✅ CAMBIAR DE 'sesiones' A 'asistencias'
          })
        })
          .then(res => res.json())
          .then(resp => {
            alert(resp.mensaje || 'Asistencia guardada.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAsistencia'));
            if (modal) modal.hide();
          })
          .catch(err => {
            console.error(err);
            alert('Error al guardar asistencia.');
          });
      });
    })
    .catch(error => {
      console.error("Error al cargar sesiones:", error);
    });
});
