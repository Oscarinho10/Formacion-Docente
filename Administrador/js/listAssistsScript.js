const data = [
    {
        nombre: "Taller de Liderazgo",
        inicio: "2024-06-01",
        fin: "2024-06-03",
        estado: "Activa"
    },
    {
        nombre: "Curso de Oratoria",
        inicio: "2024-06-10",
        fin: "2024-06-12",
        estado: "Activa"
    },
    {
        nombre: "Seminario de Innovación",
        inicio: "2024-06-15",
        fin: "2024-06-16",
        estado: "Inactiva"
    },
    {
        nombre: "Voluntariado Ambiental",
        inicio: "2024-07-01",
        fin: "2024-07-10",
        estado: "Activa"
    },
    {
        nombre: "Proyecto Social",
        inicio: "2024-07-15",
        fin: "2024-07-18",
        estado: "Inactiva"
    },
    {
        nombre: "Conferencia de Ética",
        inicio: "2024-07-25",
        fin: "2024-07-25",
        estado: "Inactiva"
    }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();

    filtered = data.filter(item =>
        item.nombre.toLowerCase().includes(search) ||
        item.estado.toLowerCase().includes(search) ||
        item.inicio.toLowerCase().includes(search) ||
        item.fin.toLowerCase().includes(search)
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
                <td class="text-center">${item.inicio}</td>
                <td class="text-center">${item.fin}</td>
                <td class="text-center">${item.estado}</td>
                <td class="text-center">
                    <button href="#" class="btn btn-sm btn-primary">Ver Lista</button>
                    <button href="#" class="btn btn-sm btn-general">Ver Participantes</button>
                </td>
            </tr>
        `);
    });

    $('#pagination').html('');
    if (totalPages > 1) {
        $('#pagination').append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" id="prevPage">&laquo;</a>
            </li>`);

        for (let i = 1; i <= totalPages; i++) {
            $('#pagination').append(`
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#">${i}</a>
                </li>`);
        }

        $('#pagination').append(`
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" id="nextPage">&raquo;</a>
            </li>`);
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

    $('.btn-edit').click(function () {
        const nombre = $(this).closest('tr').find('td:eq(0)').text();
        console.log('Editar actividad:', nombre);
        // Aquí puedes llamar a tu modal o redirigir a otra página
    });
}

$('#searchInput').on('input', function () {
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
