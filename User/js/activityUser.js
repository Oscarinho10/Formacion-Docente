const data = actividadesData;
const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();
    const modalityFilter = $('#filterModality').val();

    // Filtrar datos
    filtered = data.filter(function (item) {
        var matchesSearch =
            item.nombre.toLowerCase().indexOf(search) !== -1 ||
            item.horas.toLowerCase().indexOf(search) !== -1 ||
            item.modalidad.toLowerCase().indexOf(search) !== -1 ||
            item.cupo.toLowerCase().indexOf(search) !== -1;

        var matchesModality = !modalityFilter || item.modalidad === modalityFilter;

        return matchesSearch && matchesModality;
    });

    var totalPages = Math.ceil(filtered.length / rowsPerPage);
    var start = (currentPage - 1) * rowsPerPage;
    var end = Math.min(start + rowsPerPage, filtered.length);
    var visibleData = filtered.slice(start, end);

    // Actualizar información de paginación
    $('#paginationInfo').html('Mostrando ' + (start + 1) + '-' + end + ' de ' + filtered.length + ' registros');

    $('#tableBody').html('');
    $.each(visibleData, function (index, item) {
        $('#tableBody').append(
            '<tr>' +
            '<td>' + item.nombre + '</td>' +
            '<td>' + item.horas + '</td>' +
            '<td>' + item.modalidad + '</td>' +
            '<td>' + item.cupo + '</td>' +
            '<td class="table-actions">' +
            '<button class="btn btn-secondary btn-sm verMasBtn" ' +
            'data-nombre="' + item.nombre + '" ' +
            'data-descripcion="' + item.descripcion + '" ' +
            'data-dirigido_a="' + item.dirigido_a + '" ' +
            'data-modalidad="' + item.modalidad + '" ' +
            'data-lugar="' + item.lugar + '" ' +
            'data-clasificacion="' + item.clasificacion + '" ' +
            'data-cupo="' + item.cupo + '" ' +
            'data-total_horas="' + item.total_horas + '" ' +
            'data-estado="' + item.estado + '" ' +
            'data-descripcion_horarios="' + item.descripcion_horarios + '" ' +
            'data-bs-toggle="modal" data-bs-target="#modalActividad">' +
            'Ver más</button>'
            +
            '<a href="registerActivity.php?curso=' + encodeURIComponent(item.nombre) + '" class="btn btn-sm btn-success">Inscribirme</a>' +
            '</td>' +
            '</tr>'
        );
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.verMasBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('modalNombre').innerText = this.dataset.nombre;
                document.getElementById('modalDescripcion').innerText = this.dataset.descripcion;
                document.getElementById('modalDirigido').innerText = this.dataset.dirigido_a;
                document.getElementById('modalModalidad').innerText = this.dataset.modalidad;
                document.getElementById('modalLugar').innerText = this.dataset.lugar;
                document.getElementById('modalClasificacion').innerText = this.dataset.clasificacion;
                document.getElementById('modalCupo').innerText = this.dataset.cupo;
                document.getElementById('modalHoras').innerText = this.dataset.total_horas;
                document.getElementById('modalEstado').innerText = this.dataset.estado;
                document.getElementById('modalHorarios').innerText = this.dataset.descripcion_horarios;
            });
        });
    });


    $('#pagination').html('');
    if (totalPages > 1) {
        // Botón Anterior
        $('#pagination').append(
            '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '">' +
            '<a class="page-link" href="#" aria-label="Previous" id="prevPage">' +
            '<span aria-hidden="true">&laquo;</span>' +
            '</a>' +
            '</li>'
        );

        // Botones de página
        for (var i = 1; i <= totalPages; i++) {
            $('#pagination').append(
                '<li class="page-item ' + (i === currentPage ? 'active' : '') + '">' +
                '<a class="page-link" href="#">' + i + '</a>' +
                '</li>'
            );
        }

        // Botón Siguiente
        $('#pagination').append(
            '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '">' +
            '<a class="page-link" href="#" aria-label="Next" id="nextPage">' +
            '<span aria-hidden="true">&raquo;</span>' +
            '</a>' +
            '</li>'
        );
    }

    // Eventos de paginación
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

// Eventos para filtros
$('#searchInput').on('input', function () {
    currentPage = 1;
    renderTable();
});

$('#filterModality').change(function () {
    currentPage = 1;
    renderTable();
});

$('#clearFilters').click(function () {
    $('#searchInput').val('');
    $('#filterModality').val('');
    currentPage = 1;
    renderTable();
});

$(document).ready(function () {
    renderTable();
});

$('.btn-vermas').click(function () {
    $('#modalLugar').text($(this).data('lugar'));
    $('#modalTipo').text($(this).data('tipo'));
    $('#modalInicio').text($(this).data('inicio'));
    $('#modalFin').text($(this).data('fin'));
    $('#modalDirigido').text($(this).data('dirigido'));
    $('#modalHorario').text($(this).data('horario'));

    $('#detalleModal').modal('show');
});