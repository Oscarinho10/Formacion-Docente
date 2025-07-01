let data = [];
const rowsPerPage = 5;
let currentPage = 1;
let filtered = [];

function cargarDatos() {
    Swal.fire({
        title: 'Cargando...',
        text: 'Por favor espera',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('controller/viewUserSuperController.php')  // Asegúrate que este archivo devuelva solo usuarios activos
        .then(res => res.json())
        .then(json => {
            data = json;
            renderTable();
            Swal.close();
        })
        .catch(err => {
            console.error("Error al cargar participantes activos:", err);
            Swal.fire('Error', 'No se pudo cargar la lista de participantes.', 'error');
        });
}

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();

    filtered = data.filter(item =>
        item.nombre.toLowerCase().includes(search) ||
        item.numero_control_rfc.toLowerCase().includes(search) ||
        item.correo.toLowerCase().includes(search) ||
        item.perfil_academico.toLowerCase().includes(search)
    );

    const totalPages = Math.ceil(filtered.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = Math.min(start + rowsPerPage, filtered.length);
    const visibleData = filtered.slice(start, end);

    $('#paginationInfo').text(`Mostrando ${start + 1}-${end} de ${filtered.length} registros`);
    $('#tableBody').html('');

    if (filtered.length === 0) {
        $('#tableBody').html(`
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    No hay participantes activos.
                </td>
            </tr>
        `);
        $('#pagination').html('');
        return;
    }

    visibleData.forEach(item => {
        $('#tableBody').append(`
            <tr>
                <td>${item.nombre}</td>
                <td>${item.numero_control_rfc}</td>
                <td>${item.correo}</td>
                <td>${item.perfil_academico}</td>
                <td>
                    <button class="btn btn-secondary btn-sm verMasBtn"
                        data-nombre="${item.nombre}"
                        data-apellido-paterno="${item.apellido_paterno}"
                        data-apellido-materno="${item.apellido_materno}"
                        data-fecha="${item.fecha_nacimiento}"
                        data-sexo="${item.sexo}"
                        data-unidad="${item.unidad_academica}"
                        data-grado="${item.grado_academico}"
                        data-correo="${item.correo}"
                        data-perfil="${item.perfil_academico}"
                        data-fecha-registro="${item.fecha_registro}"
                        data-bs-toggle="modal"
                        data-bs-target="#modalParticipants">
                        Ver más <i class="fas fa-eye"></i>
                    </button>
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

$(document).ready(function () {
    cargarDatos();

    $('#searchInput').on('input', function () {
        currentPage = 1;
        renderTable();
    });

    $(document).on('click', '.verMasBtn', function () {
        const nombre = $(this).data('nombre');
        const paterno = $(this).data('apellido-paterno');
        const materno = $(this).data('apellido-materno');
        const fecha = $(this).data('fecha');
        const sexo = $(this).data('sexo');
        const numero_control = $(this).data('numero_control_rfc');
        const correo = $(this).data('correo');
        const unidad = $(this).data('unidad');
        const grado = $(this).data('grado');
        const perfil = $(this).data('perfil');
        const fecha_registro = $(this).data('fecha-registro');


        $('#modalNombreCompleto').text(`${nombre} ${paterno} ${materno}`);
        $('#modalFecha').text(fecha);
        $('#modalSexo').text(sexo);
        $('#modalCorreo').text(correo);
        $('#modalControl').text(numero_control);
        $('#modalUnidad').text(unidad);
        $('#modalGrado').text(grado);
        $('#modalPerfil').text(perfil);
        $('#modalFechaRegistro').text(fecha_registro);

    });
});
