const data = [{
    nombre: "Alejandro Morales",
    perfil: "Tiempo completo",
    unidad: "Centro de investigaciones de mota"
},
{
    nombre: "Ana Torres",
    perfil: "Ingeniería en Software",
    unidad: "Facultad de Ingeniería"
},
{
    nombre: "Luis Rivas",
    perfil: "Matemáticas Aplicadas",
    unidad: "Facultad de Ciencias"
},
{
    nombre: "Marta León",
    perfil: "Comunicación",
    unidad: "Facultad de Humanidades"
},
{
    nombre: "Claudia Díaz",
    perfil: "Biología Molecular",
    unidad: "Facultad de Ciencias Naturales"
},
{
    nombre: "Pedro Jiménez",
    perfil: "Arquitectura",
    unidad: "Facultad de Arquitectura"
},
{
    nombre: "Julio Suárez",
    perfil: "Sistemas Computacionales",
    unidad: "Facultad de Ingeniería"
},
{
    nombre: "Karen López",
    perfil: "Diseño Gráfico",
    unidad: "Facultad de Artes"
}
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
                    <td class="text-center">${item.nombre}</td>
                    <td class="text-center">${item.perfil}</td>
                    <td class="text-center">${item.unidad}</td>
                    <td class="acciones">
                        <a href="editInstructor.php" class="btn btn-sm btn-general">Editar</a>
                    </td>
                </tr>
            `);
    });

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

$('#filterUnidad, #filterPerfil').change(function () {
    currentPage = 1;
    renderTable();
});

$('#clearFilters').click(function () {
    $('#searchInput').val('');
    $('#filterUnidad, #filterPerfil').val('');
    currentPage = 1;
    renderTable();
});

$(document).ready(function () {
    renderTable();
});