document.addEventListener("DOMContentLoaded", function () {
    let datos = [];
    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    // ✅ Función para calcular edad desde fecha de nacimiento
    function calcularEdad(fechaNacimientoStr) {
        const fechaSolo = fechaNacimientoStr.split(' ')[0];
        const partes = fechaSolo.split('-');
        if (partes.length !== 3) return 0;

        const nacimiento = new Date(partes[0], partes[1] - 1, partes[2]);
        const hoy = new Date();

        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const m = hoy.getMonth() - nacimiento.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad;
    }

    Swal.fire({
        title: 'Cargando participantes...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('controller/viewUserSuperController.php')
        .then(response => response.json())
        .then(data => {
            datos = data;
            renderTable(1);
        })
        .catch(error => {
            console.error('Error al obtener participantes:', error);
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Error al cargar datos.</td></tr>`;
        })
        .finally(() => {
            Swal.close();
        });


    function renderPagination(totalItems, currentPage) {
        const totalPages = Math.ceil(totalItems / rowsPerPage);
        pagination.innerHTML = "";

        const prevLi = document.createElement("li");
        prevLi.className = "page-item" + (currentPage === 1 ? " disabled" : "");
        prevLi.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
        prevLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) renderTable(currentPage - 1);
        });
        pagination.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = "page-item" + (i === currentPage ? " active" : "");
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener("click", (e) => {
                e.preventDefault();
                renderTable(i);
            });
            pagination.appendChild(li);
        }

        const nextLi = document.createElement("li");
        nextLi.className = "page-item" + (currentPage === totalPages ? " disabled" : "");
        nextLi.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
        nextLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) renderTable(currentPage + 1);
        });
        pagination.appendChild(nextLi);

        paginationInfo.textContent = `Página ${currentPage} de ${totalPages || 1}`;
    }

    function renderTable(page = 1) {
        const search = searchInput.value.toLowerCase();
        const filtered = datos.filter(d =>
            d.nombre.toLowerCase().includes(search) ||
            d.correo.toLowerCase().includes(search) ||
            d.numero_control_rfc.toLowerCase().includes(search)
        );

        const start = (page - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        tableBody.innerHTML = "";

        if (paginated.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center"> <i class="fas fa-exclamation-circle"> </i> No se encontraron resultados</td></tr>`;
        } else {
            paginated.forEach((participante, idx) => {
                const realIndex = datos.indexOf(participante);
                const checked = participante.estado === 'activo' ? "checked" : "";

                tableBody.innerHTML += `
                    <tr>
                        <td>${participante.nombre}</td>
                        <td>${participante.numero_control_rfc}</td>
                        <td>${participante.correo}</td>
                        <td>${participante.perfil_academico}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" ${checked} data-index="${realIndex}" data-id="${participante.id_usuario}" class="estado-toggle">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-secondary btn-sm verMasBtn"
                                data-id="${participante.id_usuario}"
                                data-nombre="${participante.nombre}"
                                data-apellido-paterno="${participante.apellido_paterno}"
                                data-apellido-materno="${participante.apellido_materno}"
                                data-fecha="${participante.fecha_nacimiento}"
                                data-sexo="${participante.sexo}"
                                data-unidad="${participante.unidad_academica}"
                                data-grado="${participante.grado_academico}"
                                data-correo="${participante.correo}"
                                data-perfil="${participante.perfil_academico}"
                                data-fecha-registro="${participante.fecha_registro}"
                                data-numero_control_rfc="${participante.numero_control_rfc}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalParticipants">
                                Ver más <i class="fas fa-eye"></i>
                            </button>
                            <a href="editParticipant.php?id=${participante.id_usuario}" class="btn btn-sm btn-general ml-2">
                                Editar <i class="fas fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                `;
            });
        }

        renderPagination(filtered.length, page);
        addToggleListeners();
    }

    function addToggleListeners() {
        const toggles = document.querySelectorAll('.estado-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function () {
                const index = this.getAttribute('data-index');
                const idUsuario = this.getAttribute('data-id');
                const nuevoEstado = this.checked ? 'activo' : 'inactivo';

                Swal.fire({
                    title: `¿Estás seguro?`,
                    text: `El participante será marcado como ${nuevoEstado}.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, cambiar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('controller/updateStateParticipant.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `id_usuario=${idUsuario}&estado=${nuevoEstado}`
                        })
                            .then(response => response.text())
                            .then(response => {
                                if (response === 'ok') {
                                    datos[index].estado = nuevoEstado;
                                    Swal.fire('Actualizado', 'El estado se ha actualizado correctamente.', 'success');
                                    renderTable(currentPage);
                                } else {
                                    throw new Error(response);
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', 'Hubo un problema al actualizar el estado.', 'error');
                                this.checked = !this.checked;
                            });
                    } else {
                        this.checked = !this.checked;
                    }
                });
            });
        });
    }

    searchInput.addEventListener("input", () => renderTable(1));

    document.addEventListener("click", function (e) {
        if (e.target.closest(".verMasBtn")) {
            const btn = e.target.closest(".verMasBtn");
            const idUsuario = btn.dataset.id;

            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            };

            const fechaNacimiento = btn.dataset.fecha;
            const edadCalculada = calcularEdad(fechaNacimiento);

            setText("modalNombreCompleto", `${btn.dataset.nombre} ${btn.dataset.apellidoPaterno} ${btn.dataset.apellidoMaterno}`);
            setText("modalEdad", `${edadCalculada} años`);
            setText("modalSexo", btn.dataset.sexo);
            setText("modalCorreo", btn.dataset.correo);
            setText("modalControl", btn.dataset.numero_control_rfc);
            setText("modalUnidad", btn.dataset.unidad);
            setText("modalGrado", btn.dataset.grado);
            setText("modalPerfil", btn.dataset.perfil);
            setText("modalFechaRegistro", btn.dataset.fechaRegistro);
        }
    });
});
