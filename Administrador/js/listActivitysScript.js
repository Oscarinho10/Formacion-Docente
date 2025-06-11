const data = [
    {
        nombre: "Taller de Liderazgo",
        horas: 10,
        estado: "Aprobada"
    },
    {
        nombre: "Curso de Oratoria",
        horas: 8,
        estado: "Pendiente"
    },
    {
        nombre: "Seminario de Innovación",
        horas: 15,
        estado: "Rechazada"
    },
    {
        nombre: "Voluntariado Ambiental",
        horas: 12,
        estado: "Aprobada"
    },
    {
        nombre: "Proyecto Social",
        horas: 20,
        estado: "Pendiente"
    },
    {
        nombre: "Conferencia de Ética",
        horas: 5,
        estado: "Aprobada"
    },
    {
        nombre: "Hackathon Interuniversitario",
        horas: 18,
        estado: "Pendiente"
    }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();

    filtered = data.filter(item =>
        item.nombre.toLowerCase().includes(search) ||
        item.estado.toLowerCase().includes(search)
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
                <td class="text-center">${item.horas}</td>
                <td class="text-center"><label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label></td>
                <td class="text-center"><button class="btn btn-sm btn-secondary">Ver más</button>
                <button class="btn btn-primary btn-sm btn-edit">Editar</button>
                <button class="btn btn-sm btn-general">Subir Evidencia</button></td>
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
        // Aquí puedes mostrar un modal o redirigir a otra vista
    });
}

$('#searchInput').on('input', function () {
    currentPage = 1;
    renderTable();
});

$('#clearFilters').click(function () {
    $('#searchInput').val('');
    currentPage = 1;
    renderTable();
});

$(document).ready(function () {
    renderTable();
});
