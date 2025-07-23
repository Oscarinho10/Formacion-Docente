$(document).ready(function () {
    $.ajax({
        url: 'controller/getCertificateController.php',
        type: 'GET',
        data: {
            usuario_id: usuarioId
        },
        dataType: 'json',
        success: function (data) {
            var container = $('#constancias-container');
            container.empty();

            if (data.length > 0) {
                data.forEach(function (constancia) {
                    container.append(`
                        <div class="card shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex flex-column mb-3 mb-md-0">
                                    <h5 class="card-title font-weight-bold mb-2">📄 ${constancia.nombre_actividad}</h5>
                                    <p class="mb-1"><strong>Folio:</strong> ${constancia.folio}</p>
                                    <p class="mb-1"><strong>Fecha de emisión:</strong> ${constancia.fecha_emision}</p>
                                </div>
                                <div class="text-center">
                                    <button onclick="enviarConstancia(${constancia.id_constancia}, false)" class="btn btn-outline-primary btn-sm">Ver constancia</button><br>
                                    <button onclick="enviarConstancia(${constancia.id_constancia}, true)" class="btn btn-primary btn-sm mt-2">Descargar</button>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                container.append(
                    '<div class="alert alert-info" role="alert">No hay constancias disponibles.</div>'
                );
            }
        },
        error: function (xhr, status, error) {
            console.log("Error AJAX:", status, error);
            $('#constancias-container').append(
                '<div class="alert alert-danger" role="alert">Error al cargar las constancias.</div>'
            );
        }
    });
});

// ✅ Función para enviar el id_constancia de forma segura por POST
function enviarConstancia(idConstancia, download = false) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'controller/downloadConstancyController.php';
    form.target = '_blank';

    const inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'id_constancia';
    inputId.value = idConstancia;

    const inputDownload = document.createElement('input');
    inputDownload.type = 'hidden';
    inputDownload.name = 'download';
    inputDownload.value = download ? 'true' : '';

    form.appendChild(inputId);
    form.appendChild(inputDownload);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
