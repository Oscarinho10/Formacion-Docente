let actividades = [];
let filtered = [];
const rowsPerPage = 5;
let currentPage = 1;

async function fetchActividades() {
    try {
        const res = await fetch('../User/Controller/activityUserController.php'); // RUTA AL NUEVO ENDPOINT
        actividades = await res.json();
        filtered = [...actividades];
        renderTable();
    } catch (error) {
        console.error("Error al obtener actividades:", error);
    }
}

function renderTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    filtered = actividades.filter(a =>
        a.nombre.toLowerCase().includes(search)
    );

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const data = filtered.slice(start, end);

    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = "";

    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No hay actividades.</td></tr>`;
        document.getElementById('paginationInfo').innerText = "0 resultados.";
        return;
    }

    data.forEach(item => {
        const yaInscrito = item.ya_inscrito == "1";
        const cupoLleno = parseInt(item.inscritos) >= parseInt(item.cupo);

        let botonInscripcion = '';

        if (yaInscrito) {
            botonInscripcion = `<button class="btn btn-sm btn-secondary" disabled>Inscrito</button>`;
        } else if (cupoLleno) {
            botonInscripcion = `<button class="btn btn-sm btn-danger" disabled>Cupo lleno</button>`;
        } else {
            botonInscripcion = `<button class="btn btn-sm btn-general btn-aceptar" data-id="${item.id_actividad}">Inscribirme</button>`;
        }

        tbody.innerHTML += `
      <tr>
        <td>${item.nombre}</td>
        <td>${item.total_horas}</td>
        <td>${item.modalidad}</td>
        <td class="text-center">${item.inscritos}/${item.cupo}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-secondary verMasBtn"
            data-nombre="${item.nombre}"
            data-descripcion="${item.descripcion}"
            data-dirigido="${item.dirigido_a}"
            data-modalidad="${item.modalidad}"
            data-lugar="${item.lugar}"
            data-clasificacion="${item.clasificacion}"
            data-cupo="${item.cupo}"
            data-horas="${item.total_horas}"
            data-estado="${item.estado}"
            data-horarios="${item.descripcion_horarios}"
            data-bs-toggle="modal"
            data-bs-target="#modalActividad">
            Ver más
          </button>
          ${botonInscripcion}
        </td>
      </tr>
    `;
    });

    document.getElementById('paginationInfo').innerText = `Mostrando ${start + 1}-${Math.min(end, filtered.length)} de ${filtered.length}`;
    setupVerMasListeners();
    setupInscripcionListeners();
    renderPagination();
}

function setupVerMasListeners() {
    document.querySelectorAll('.verMasBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('modalNombre').innerText = this.dataset.nombre;
            document.getElementById('modalDescripcion').innerText = this.dataset.descripcion;
            document.getElementById('modalDirigido').innerText = this.dataset.dirigido;
            document.getElementById('modalModalidad').innerText = this.dataset.modalidad;
            document.getElementById('modalLugar').innerText = this.dataset.lugar;
            document.getElementById('modalClasificacion').innerText = this.dataset.clasificacion;
            document.getElementById('modalCupo').innerText = this.dataset.cupo;
            document.getElementById('modalHoras').innerText = this.dataset.horas;
            document.getElementById('modalEstado').innerText = this.dataset.estado;
            document.getElementById('modalHorarios').innerText = this.dataset.horarios;
        });
    });
}

function setupInscripcionListeners() {
    document.querySelectorAll('.btn-aceptar').forEach(btn => {
        btn.addEventListener('click', function () {
            const boton = this;
            const idActividad = boton.dataset.id;

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas inscribirte en esta actividad?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, inscribirme',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#2D882D',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ejecutar la inscripción solo si el usuario confirmó
                    fetch('../User/Controller/registerActivityController.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_actividad=${encodeURIComponent(idActividad)}`
                    })
                        .then(res => res.text())
                        .then(data => {
                            console.log("RESPUESTA RAW:", data);
                            try {
                                const parsed = JSON.parse(data);
                                if (parsed.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Inscripción exitosa',
                                        text: 'Te has inscrito correctamente.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    boton.classList.remove('btn-general', 'btn-aceptar');
                                    boton.classList.add('btn-success');
                                    boton.textContent = 'Inscrito';
                                    boton.disabled = true;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: parsed.message || 'No se pudo completar la inscripción.'
                                    });
                                }
                            } catch (e) {
                                console.error("JSON inválido:", e);
                                console.error("Contenido recibido:", data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error interno',
                                    text: 'Respuesta del servidor inválida'
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de red',
                                text: 'No se pudo conectar con el servidor.'
                            });
                            console.error(err);
                        });
                }
            });
        });
    });
}



function renderPagination() {
    const pageCount = Math.ceil(filtered.length / rowsPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = "";

    for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', e => {
            e.preventDefault();
            currentPage = i;
            renderTable();
        });
        pagination.appendChild(li);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('searchInput').addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    fetchActividades();
});
