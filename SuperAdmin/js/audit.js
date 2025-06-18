document.addEventListener("DOMContentLoaded", function () {
    const datos = [
        { fecha: "2025-06-01", hora: "09:00", admin: "Juan Pérez", movimiento: "Alta de usuario", modulo: "Usuarios" },
        { fecha: "2025-06-02", hora: "10:30", admin: "María López", movimiento: "Edición de producto", modulo: "Inventario" },
        { fecha: "2025-06-02", hora: "12:00", admin: "Carlos Ruiz", movimiento: "Eliminación de cliente", modulo: "Clientes" },
        { fecha: "2025-06-03", hora: "14:00", admin: "Ana Torres", movimiento: "Cambio de contraseña", modulo: "Seguridad" },
        { fecha: "2025-06-04", hora: "16:45", admin: "Juan Pérez", movimiento: "Exportación de reporte", modulo: "Reportes" },
        { fecha: "2025-06-05", hora: "08:15", admin: "María López", movimiento: "Registro de venta", modulo: "Ventas" },
        { fecha: "2025-06-05", hora: "11:20", admin: "Carlos Ruiz", movimiento: "Actualización de stock", modulo: "Inventario" },
        { fecha: "2025-06-06", hora: "13:10", admin: "Ana Torres", movimiento: "Modificación de rol", modulo: "Usuarios" },
        { fecha: "2025-06-07", hora: "15:35", admin: "Juan Pérez", movimiento: "Consulta de historial", modulo: "Auditoría" },
        { fecha: "2025-06-08", hora: "10:00", admin: "María López", movimiento: "Registro de entrada", modulo: "Almacén" },
        // Puedes agregar más si lo necesitas
    ];

    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const filterFecha = document.getElementById("filterFecha");
    const clearFilters = document.getElementById("clearFilters");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    function renderTable(page = 1) {
        const search = searchInput.value.toLowerCase();
        const fecha = filterFecha.value;

        const filtered = datos.filter(d => {
            const matchSearch =
                d.admin.toLowerCase().includes(search) ||
                d.movimiento.toLowerCase().includes(search) ||
                d.modulo.toLowerCase().includes(search);

            const matchFecha = fecha === "" || d.fecha === fecha;

            return matchSearch && matchFecha;
        });

        const start = (page - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        tableBody.innerHTML = "";

        if (paginated.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados</td></tr>`;
        } else {
            paginated.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.fecha}</td>
                    <td>${row.hora}</td>
                    <td>${row.admin}</td>
                    <td>${row.movimiento}</td>
                    <td>${row.modulo}</td>
                `;
                tableBody.appendChild(tr);
            });
        }

        renderPagination(filtered.length, page);
    }

    function renderPagination(totalItems, currentPage) {
        const totalPages = Math.ceil(totalItems / rowsPerPage);
        pagination.innerHTML = "";

        // Flecha de retroceso
        const prevLi = document.createElement("li");
        prevLi.className = "page-item" + (currentPage === 1 ? " disabled" : "");
        prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Anterior">&laquo;</a>`;
        prevLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) renderTable(currentPage - 1);
        });
        pagination.appendChild(prevLi);

        // Páginas numéricas
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

        // Flecha de avance
        const nextLi = document.createElement("li");
        nextLi.className = "page-item" + (currentPage === totalPages ? " disabled" : "");
        nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Siguiente">&raquo;</a>`;
        nextLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) renderTable(currentPage + 1);
        });
        pagination.appendChild(nextLi);

        paginationInfo.textContent = `Página ${currentPage} de ${totalPages || 1}`;
    }
    searchInput.addEventListener("input", () => renderTable(1));
    filterFecha.addEventListener("change", () => renderTable(1));
    clearFilters.addEventListener("click", () => {
        searchInput.value = "";
        filterFecha.value = "";
        renderTable(1);
    });

    renderTable(1);
});
