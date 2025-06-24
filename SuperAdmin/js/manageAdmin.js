document.addEventListener("DOMContentLoaded", function () {
    const datos = [
        { nombre: "Juan Pérez", correo: "juan.perez@uaemex.mx", control: "A12345", activo: true },
        { nombre: "María López", correo: "maria.lopez@uaemex.mx", control: "A12346", activo: false },
        { nombre: "Carlos Ruiz", correo: "carlos.ruiz@uaemex.mx", control: "A12347", activo: true },
        { nombre: "Ana Torres", correo: "ana.torres@uaemex.mx", control: "A12348", activo: true },
        { nombre: "Luis Martínez", correo: "luis.martinez@uaemex.mx", control: "A12349", activo: false },
        { nombre: "Elena Gómez", correo: "elena.gomez@uaemex.mx", control: "A12350", activo: true },
        { nombre: "Pedro Sánchez", correo: "pedro.sanchez@uaemex.mx", control: "A12351", activo: false },
        { nombre: "Lucía Herrera", correo: "lucia.herrera@uaemex.mx", control: "A12352", activo: true },
    ];

    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    function renderTable(page = 1) {
        const search = searchInput.value.toLowerCase();
        const filtered = datos.filter(d =>
            d.nombre.toLowerCase().includes(search) ||
            d.correo.toLowerCase().includes(search) ||
            d.control.toLowerCase().includes(search)
        );

        const start = (page - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        tableBody.innerHTML = "";

        if (paginated.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados</td></tr>`;
        } else {
            paginated.forEach((actividad, idx) => {
                const realIndex = datos.indexOf(actividad);
                const checked = actividad.activo ? "checked" : "";
                tableBody.innerHTML += `
                    <tr>
                        <td>${actividad.nombre}</td>
                        <td>${actividad.correo}</td>
                        <td>${actividad.control}</td>
                        <td class="text-center">
                            <label class="switch">
                                <input type="checkbox" ${checked} data-index="${realIndex}" class="estado-toggle">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <a href="editAdmin.php" class="btn btn-sm btn-general ml-2">Editar</a>
                        </td>
                    </tr>
                `;
            });
        }

        renderPagination(filtered.length, page);
        addToggleListeners(); // ← Añadido aquí
    }

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

    function addToggleListeners() {
        const switches = document.querySelectorAll('.estado-toggle');
        switches.forEach(switchEl => {
            switchEl.addEventListener('change', function () {
                const index = parseInt(this.getAttribute('data-index'));
                const estadoActual = datos[index].activo;
                const nuevoEstado = !estadoActual;

                Swal.fire({
                    title: `¿Deseas cambiar el estado?`,
                    text: `Actualmente está "${estadoActual ? 'Activo' : 'Inactivo'}".`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: `Sí, cambiar a "${nuevoEstado ? 'Activo' : 'Inactivo'}"`,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        datos[index].activo = nuevoEstado;
                        renderTable(currentPage);
                        Swal.fire({
                            title: '¡Estado actualizado!',
                            text: `Ahora está "${nuevoEstado ? 'Activo' : 'Inactivo'}".`,
                            icon: nuevoEstado ? 'success' : 'warning',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        this.checked = estadoActual; // revierte toggle visualmente
                    }
                });
            });
        });
    }

    searchInput.addEventListener("input", () => renderTable(1));
    renderTable(1);
});
