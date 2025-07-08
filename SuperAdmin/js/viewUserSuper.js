document.addEventListener("DOMContentLoaded", function () {
    let datos = [];
    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    fetch('controller/viewUserSuperController.php')
        .then(response => response.json())
        .then(data => {
            datos = data;
            renderTable(1);
        })
        .catch(error => {
            console.error('Error al obtener participantes:', error);
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Error al cargar datos.</td></tr>`;
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
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados</td></tr>`;
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
                                data-bs-toggle="modal"
                                data-bs-target="#modalParticipants">
                                Ver más <i class="fas fa-eye"></i>
                            </button>
                            

                          
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
                                    if (nuevoEstado === 'inactivo') renderTable(currentPage);
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
            document.getElementById("modalNombreCompleto").textContent =
                `${btn.dataset.nombre} ${btn.dataset.apellidoPaterno} ${btn.dataset.apellidoMaterno}`;
            document.getElementById("modalFecha").textContent = btn.dataset.fecha;
            document.getElementById("modalSexo").textContent = btn.dataset.sexo;
            document.getElementById("modalCorreo").textContent = btn.dataset.correo;
            document.getElementById("modalControl").textContent = btn.dataset.numero_control_rfc;
            document.getElementById("modalUnidad").textContent = btn.dataset.unidad;
            document.getElementById("modalGrado").textContent = btn.dataset.grado;
            document.getElementById("modalPerfil").textContent = btn.dataset.perfil;
            document.getElementById("modalFechaRegistro").textContent = btn.dataset.fechaRegistro;
        }
    });
});
