document.addEventListener("DOMContentLoaded", function () {
    let datos = [];
    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");

    // Obtener datos reales desde PHP
    fetch('controller/getAdmin.php')
        .then(response => response.json())
        .then(data => {
            datos = data;
            renderTable(1);
        })
        .catch(error => {
            console.error('Error al obtener administradores:', error);
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
            d.control.toLowerCase().includes(search)
        );

        const start = (page - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        tableBody.innerHTML = "";

        if (paginated.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados</td></tr>`;
        } else {
            paginated.forEach((admin, idx) => {
                const realIndex = datos.indexOf(admin);
                const checked = admin.activo ? "checked" : "";
                tableBody.innerHTML += `
                    <tr>
                        <td>${admin.nombre}</td>
                        <td>${admin.correo}</td>
                        <td>${admin.control}</td>
                        <td class="text-center">
                            <label class="switch">
                                <input type="checkbox" ${checked} data-index="${realIndex}" class="estado-toggle">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <a href="editAdmin.php?control=${admin.control}" class="btn btn-sm btn-general ml-2">Editar</a>
                        </td>
                    </tr>
                `;
            });
        }

        renderPagination(filtered.length, page);
        addToggleListeners();
    }

    // (mantén renderPagination y addToggleListeners como los tienes)
    searchInput.addEventListener("input", () => renderTable(1));
});
