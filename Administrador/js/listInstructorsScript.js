const data = [
    { nombre: "Dr. Ana Torres", perfil: "Ingeniería en Software", unidad: "Facultad de Ingeniería" },
    { nombre: "Mtro. Luis Rivas", perfil: "Matemáticas Aplicadas", unidad: "Facultad de Ciencias" },
    { nombre: "Lic. Marta León", perfil: "Comunicación", unidad: "Facultad de Humanidades" },
    { nombre: "Dra. Claudia Díaz", perfil: "Biología Molecular", unidad: "Facultad de Ciencias Naturales" },
    { nombre: "Mtro. Pedro Jiménez", perfil: "Arquitectura", unidad: "Facultad de Arquitectura" },
    { nombre: "Ing. Julio Suárez", perfil: "Sistemas Computacionales", unidad: "Facultad de Ingeniería" },
    { nombre: "Lic. Karen López", perfil: "Diseño Gráfico", unidad: "Facultad de Artes" }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();

    filtered = data.filter(item =>
        item.nombre.toLowerCase().includes(search) ||
        item.perfil.toLowerCase().includes(search) ||
        item.unidad.toLowerCase().includes(search)
    );

    const totalPages = Math.ceil(filtered.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = Math.min(start + rowsPerPage, filtered.length);
    const visibleData = filtered.slice(start, end);

    $('#paginationInfo').text(`Mostrando ${start + 1}-${end} de ${filtered.length} registros`);
    $('#tableBody').html('');

    visibleData.forEach(item => {
        $('#tableBody').append(`
            <tr>
                <td>${item.nombre}</td>
                <td>${item.perfil}</td>
                <td>${item.unidad}</td>
                <td class="text-center acciones">
                    <button class="btn btn-secondary btn-sm verMasBtn"
                        data-nombre="${item.nombre}"
                        data-perfil="${item.perfil}"
                        data-unidad="${item.unidad}"
                        data-bs-toggle="modal"
                        data-bs-target="#modalInstructor">
                        Ver más
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-general" onclick="window.location.href='editInstructor.php'"><i class="fas fa-pen"></i> Editar</button>
                </td>
            </tr>
        `);
    });

    // Eventos para botón "Ver más"
    setTimeout(() => {
        const botones = document.querySelectorAll('.verMasBtn');
        botones.forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('modalNombre').innerText = this.dataset.nombre;
                document.getElementById('modalPerfil').innerText = this.dataset.perfil;
                document.getElementById('modalUnidad').innerText = this.dataset.unidad;
            });
        });
    }, 0);

    $('#pagination').html('');
    if (totalPages > 1) {
        $('#pagination').append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" id="prevPage">&laquo;</a>
            </li>
        `);

        for (let i = 1; i <= totalPages; i++) {
            $('#pagination').append(`
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#">${i}</a>
                </li>
            `);
        }

        $('#pagination').append(`
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" id="nextPage">&raquo;</a>
            </li>
        `);
    }

    $('#pagination a').not('#prevPage, #nextPage').click(function (e) {
        e.preventDefault();
        currentPage = parseInt($(this).text());
        renderTable();
    });

    $('#prevPage').click(function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    $('#nextPage').click(function (e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
        }
    });
}

$('#searchInput').on('input', function () {
    currentPage = 1;
    renderTable();
});

$(document).ready(function () {
    renderTable();
});
