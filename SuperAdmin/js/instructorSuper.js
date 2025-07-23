let data = [];
const rowsPerPage = 5;
let currentPage = 1;
let filtered = [];

function cargarInstructores() {
    fetch('controller/instructorSuperController.php')
        .then(res => res.json())
        .then(json => {
            if (!Array.isArray(json)) {
                throw new Error(json.error || 'Respuesta inesperada del servidor');
            }
            data = json;
            currentPage = 1;
            renderTable();
        })
        .catch(err => {
            console.error("Error al cargar instructores:", err);
            Swal.fire('Error', 'No se pudo obtener la lista de instructores.', 'error');
        });
}

function calcularEdad(fechaNacimiento) {
    const fecha = new Date(fechaNacimiento);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fecha.getFullYear();
    const mes = hoy.getMonth() - fecha.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
        edad--;
    }
    return edad;
}

function renderTable() {
    const search = $('#searchInput').val().toLowerCase();

    filtered = data.filter(item =>
        item.nombre.toLowerCase().includes(search) ||
        item.perfil_academico.toLowerCase().includes(search) ||
        item.unidad_academica.toLowerCase().includes(search)
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
            <td colspan="5" class="text-center text-muted">
                 <i class="fas fa-exclamation-circle"> </i> No hay instructores para mostrar.
            </td>
        </tr>
    `);
        $('#pagination').html('');
        $('#paginationInfo').text('Mostrando 0 de 0 registros');
        return;
    }

    visibleData.forEach(item => {
        $('#tableBody').append(`
    <tr>
        <td>${item.nombre}</td>
        <td>${item.numero_control_rfc}</td>
        <td>${item.perfil_academico}</td>
        <td>${item.unidad_academica}</td>
        
        <td>
            <label class="switch">
                <input type="checkbox" ${item.estado === 'activo' ? 'checked' : ''} 
                    onchange="toggleEstado(${item.id_usuario}, this.checked)">
                <span class="slider"></span>
            </label>
        </td>
        <td class="text-center acciones">
            <button class="btn btn-secondary btn-sm verMasBtn"
                data-nombre="${item.nombre}"
                data-apellido_paterno="${item.apellido_paterno}"
                data-apellido_materno="${item.apellido_materno}"
                data-perfil="${item.perfil_academico}"
                data-unidad="${item.unidad_academica}"
                data-correo="${item.correo_electronico}"
                data-sexo="${item.sexo}"
                data-grado="${item.grado_academico}"
                data-fecha="${item.fecha_nacimiento}"
                data-fecha-registro="${item.fecha_registro}"
                data-bs-toggle="modal"
                data-bs-target="#modalInstructor">
                Ver más <i class="fas fa-eye"></i>
            </button>

            <button class="btn btn-sm btn-general" onclick="window.location.href='editInstructor.php?id=${item.id_usuario}'">
                Editar <i class="fas fa-pen"></i> 
            </button>

            <button  class="btn btn-sm btn-general" onclick="window.location.href='instructorConstancy.php?id=${item.id_usuario}'">
                Reconocimientos <i class="fas fa-eye"></i>
            </button>
        </td>
    </tr>
`);

    });

    setTimeout(() => {
        document.querySelectorAll('.verMasBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const nombreCompleto = `${this.dataset.nombre} ${this.dataset.apellido_paterno} ${this.dataset.apellido_materno}`;
                const fechaNacimiento = this.dataset.fecha;
                const edad = calcularEdad(fechaNacimiento);

                $('#modalNombre').text(nombreCompleto);
                $('#modalPerfil').text(this.dataset.perfil);
                $('#modalUnidad').text(this.dataset.unidad);
                $('#modalCorreo').text(this.dataset.correo);
                $('#modalSexo').text(this.dataset.sexo);
                $('#modalGrado').text(this.dataset.grado);
                $('#modalEdad').text(edad + " años");
                $('#modalFecha').text(fechaNacimiento);
                $('#modalFechaRegistro').text(this.dataset.fechaRegistro);
            });
        });
    }, 0);

    $('#pagination').html('');
    if (totalPages > 1) {
        $('#pagination').append(`<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" id="prevPage">&laquo;</a></li>`);

        for (let i = 1; i <= totalPages; i++) {
            $('#pagination').append(`<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#">${i}</a></li>`);
        }

        $('#pagination').append(`<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" id="nextPage">&raquo;</a></li>`);
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

function toggleEstado(id, isActive) {
    const nuevoEstado = isActive ? 'activo' : 'inactivo';
    const accion = isActive ? 'activar' : 'desactivar';

    Swal.fire({
        title: `¿Estás seguro que deseas ${accion} este instructor?`,
        text: `El instructor será marcado como "${nuevoEstado}".`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('controller/instructorSuperController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&estado=${nuevoEstado}`
            })
                .then(res => res.json())
                .then(json => {
                    if (json.success) {
                        Swal.fire('Actualizado', `El estado fue cambiado a "${nuevoEstado}".`, 'success');
                        cargarInstructores();
                    } else {
                        Swal.fire('Error', json.error || 'No se pudo actualizar el estado.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Ocurrió un error al actualizar el estado.', 'error');
                });
        } else {
            cargarInstructores(); // revierte el checkbox
        }
    });
}

$(document).ready(function () {
    cargarInstructores();
    $('#searchInput').on('input', function () {
        currentPage = 1;
        renderTable();
    });
});
