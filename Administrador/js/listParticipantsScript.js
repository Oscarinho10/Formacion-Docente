const data = [
    {
        nombre: "Carlos Pérez",
        numero_control_rfc: "A123456",
        correo: "carlos@example.com",
        perfil_academico: "Ingeniería en Software",
        unidad_academica: "Facultad de Ingeniería"
    },
    {
        nombre: "Lucía Ramírez",
        numero_control_rfc: "B654321",
        correo: "lucia@example.com",
        perfil_academico: "Arquitectura",
        unidad_academica: "Facultad de Arquitectura"
    },
    {
        nombre: "Miguel Torres",
        numero_control_rfc: "C987654",
        correo: "miguel@example.com",
        perfil_academico: "Matemáticas Aplicadas",
        unidad_academica: "Facultad de Ciencias"
    },
    {
        nombre: "Andrea Martínez",
        numero_control_rfc: "D123789",
        correo: "andrea@example.com",
        perfil_academico: "Comunicación",
        unidad_academica: "Facultad de Humanidades"
    },
    {
        nombre: "Raúl Jiménez",
        numero_control_rfc: "E456321",
        correo: "raul@example.com",
        perfil_academico: "Biología Molecular",
        unidad_academica: "Facultad de Ciencias Naturales"
    },
    {
        nombre: "Sofía Díaz",
        numero_control_rfc: "F321456",
        correo: "sofia@example.com",
        perfil_academico: "Diseño Gráfico",
        unidad_academica: "Facultad de Artes"
    }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();
    const unidadFilter = $('#filterUnidad').val();
    const perfilFilter = $('#filterPerfil').val();

    filtered = data.filter(item =>
        (item.nombre.toLowerCase().includes(search) ||
         item.numero_control_rfc.toLowerCase().includes(search) ||
         item.correo.toLowerCase().includes(search)) &&
        (!unidadFilter || item.unidad_academica === unidadFilter) &&
        (!perfilFilter || item.perfil_academico === perfilFilter)
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
                <td class="text-center">${item.numero_control_rfc}</td>
                <td class="text-center">${item.correo}</td>
                <td class="text-center">${item.perfil_academico}</td>
                <td class="text-center">${item.unidad_academica}</td>
                <td class="text-center">
                    <button class="btn btn-success btn-action btn-accept">Aceptar</button>
                    <button class="btn btn-danger btn-action btn-deny">Denegar</button>
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

    $('.btn-accept').click(function () {
        const control = $(this).closest('tr').find('td:eq(1)').text();
        console.log('Aceptar:', control);
    });

    $('.btn-deny').click(function () {
        const control = $(this).closest('tr').find('td:eq(1)').text();
        console.log('Denegar:', control);
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

$(document).ready(renderTable);
