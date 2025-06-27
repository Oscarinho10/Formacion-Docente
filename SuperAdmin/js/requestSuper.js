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

    fetch('controller/requestProcessController.php')
        .then(res => res.json())
        .then(json => {
            data = json;
            renderTable();
            Swal.close();
        })
        .catch(err => {
            console.error("Error al cargar participantes pendientes:", err);
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
                        data-bs-toggle="modal"
                        data-bs-target="#modalParticipants">
                        Ver más <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-general btn-aceptar" data-id="${item.id_usuario}">Aceptar</button>
                    <button class="btn btn-sm btn-danger btn-denegar" data-id="${item.id_usuario}">Denegar</button>
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
        const numero_control = $(this).data('numero_control');
        const correo = $(this).data('correo');
        const unidad = $(this).data('unidad');
        const grado = $(this).data('grado');
        const perfil = $(this).data('perfil');

        $('#modalNombreCompleto').text(`${nombre} ${paterno} ${materno}`);
        $('#modalFecha').text(fecha);
        $('#modalSexo').text(sexo);
        $('#modalCorreo').text(correo);
        $('#modalControl').text(numero_control);
        $('#modalUnidad').text(unidad);
        $('#modalGrado').text(grado);
        $('#modalPerfil').text(perfil);
    });

    // ✅ ACEPTAR participante
    $(document).on('click', '.btn-aceptar', function () {
        const id_usuario = $(this).data('id');

        Swal.fire({
            icon: 'question',
            title: '¿Desea aceptar esta solicitud?',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Aceptando solicitud',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('controller/requestProcessController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_usuario=${encodeURIComponent(id_usuario)}&accion=aceptar`
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire('¡Aceptado!', 'La solicitud ha sido aceptada.', 'success').then(() => {
                                cargarDatos();
                            });
                        } else {
                            Swal.fire('Error', data.error || 'No se pudo aceptar.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.close();
                        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                    });
            }
        });
    });

    // ❌ DENEGAR participante
    $(document).on('click', '.btn-denegar', function () {
        const id_usuario = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: '¿Desea denegar esta solicitud?',
            showCancelButton: true,
            confirmButtonText: 'Denegar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Denegando solicitud',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('controller/requestProcessController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_usuario=${encodeURIComponent(id_usuario)}&accion=denegar`
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire('¡Denegado!', 'La solicitud ha sido denegada.', 'success').then(() => {
                                cargarDatos();
                            });
                        } else {
                            Swal.fire('Error', data.error || 'No se pudo denegar.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.close();
                        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                    });
            }
        });
    });
});
