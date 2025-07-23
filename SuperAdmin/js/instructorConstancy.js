document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const idInstructor = params.get('id');

    if (!idInstructor) {
        console.error('Falta el parámetro id en la URL');
        return;
    }

    fetch(`controller/getConstancyInstructorController.php?id=${idInstructor}`)
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta recibida:', data);
            renderConstancias(data);
        })
        .catch(error => {
            console.error('Error al obtener constancias:', error);
            Swal.fire('Error', 'Ocurrió un error al obtener constancias.', 'error');
            mostrarMensajeVacio();
        });
});

function renderConstancias(data) {
    const tbody = document.querySelector('#tableBodyConstancias');
    tbody.innerHTML = '';

    if (!data || data.length === 0) {
        mostrarMensajeVacio();
        return;
    }

    data.forEach(c => {
        const tr = document.createElement('tr');

        const generarBtn = `
            <a href="controller/previewInstructorConstancy.php?id_usuario=${c.id_usuario}&id_actividad=${c.id_actividad}" 
               class="btn btn-sm text-white" style="background-color:#002B5B;">
                <i class="fas fa-file-pdf"></i> Generar
            </a>
        `;

        const emitirBtn = c.id_constancia
            ? `<button class="btn btn-sm text-dark" style="background-color: #FFD700;" disabled>
                    <i class="fas fa-check-circle text-success"></i> Emitida
               </button>`
            : `<button class="btn btn-sm text-white" style="background-color: #198754;" 
                      onclick="emitirConstancia(${c.id_actividad}, ${c.id_usuario})">
                    <i class="fas fa-check-circle"></i> Emitir
               </button>`;

        tr.innerHTML = `
            <td>${c.actividad}</td>
            <td>${c.horas}</td>
            <td>${c.modalidad}</td>
            <td class="text-center d-flex justify-content-center gap-2">
                ${generarBtn}
                ${emitirBtn}
            </td>
        `;

        tbody.appendChild(tr);
    });
}

function mostrarMensajeVacio() {
    document.querySelector('#tableBodyConstancias').innerHTML = `
        <tr>
            <td colspan="6" class="text-center text-muted">
                <i class="fas fa-info-circle"></i> No se han emitido constancias para este instructor.
            </td>
        </tr>
    `;
}

function emitirConstancia(idActividad, idUsuario) {
    Swal.fire({
        title: '¿Emitir constancia?',
        text: "Una vez emitida, no se podrá modificar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, emitir',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('controller/generateConstancyInstructorController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_actividad=${idActividad}&id_usuario=${idUsuario}`
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Éxito', 'Constancia emitida correctamente.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message || 'Error al emitir constancia.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error al emitir constancia:', error);
                    Swal.fire('Error', 'Ocurrió un error al emitir la constancia.', 'error');
                });
        }
    });
}
