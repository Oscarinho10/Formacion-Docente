document.addEventListener("DOMContentLoaded", function () {
    let datos = []; // se llenará con los datos del controlador

    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const filterFecha = document.getElementById("filterFecha");
    const clearFilters = document.getElementById("clearFilters");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    function fetchMovimientos() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../SuperAdmin/controller/auditController.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    datos = JSON.parse(xhr.responseText);
                    renderTable(1);
                } catch (e) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Error cargando los datos</td></tr>`;
                }
            }
        };
        xhr.send();
    }

    function renderTable(page = 1) {
        const search = searchInput.value.toLowerCase();
        const fecha = filterFecha.value;

        const filtered = datos.filter(function (d) {
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
            paginated.forEach(function (row) {
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

        const prevLi = document.createElement("li");
        prevLi.className = "page-item" + (currentPage === 1 ? " disabled" : "");
        prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Anterior">&laquo;</a>`;
        prevLi.addEventListener("click", function (e) {
            e.preventDefault();
            if (currentPage > 1) renderTable(currentPage - 1);
        });
        pagination.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = "page-item" + (i === currentPage ? " active" : "");
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener("click", function (e) {
                e.preventDefault();
                renderTable(i);
            });
            pagination.appendChild(li);
        }

        const nextLi = document.createElement("li");
        nextLi.className = "page-item" + (currentPage === totalPages ? " disabled" : "");
        nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Siguiente">&raquo;</a>`;
        nextLi.addEventListener("click", function (e) {
            e.preventDefault();
            if (currentPage < totalPages) renderTable(currentPage + 1);
        });
        pagination.appendChild(nextLi);

        paginationInfo.textContent = `Página ${currentPage} de ${totalPages || 1}`;
    }

    searchInput.addEventListener("input", function () {
        renderTable(1);
    });

    filterFecha.addEventListener("change", function () {
        renderTable(1);
    });

    clearFilters.addEventListener("click", function () {
        searchInput.value = "";
        filterFecha.value = "";
        renderTable(1);
    });

    // Ejecutar al cargar
    fetchMovimientos();
});
