$(document).ready(function () {
    $.ajax({
        url: 'Controller/getCertificateController.php',
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
                                    <a href="Controller/downloadConstancyController.php?id_inscripcion=${constancia.id_inscripcion}" 
                                    target="_blank" 
                                    class="btn btn-outline-primary btn-sm">Ver constancia</a><br>
                                    <a href="Controller/downloadConstancyController.php?id_inscripcion=${constancia.id_inscripcion}&download=true" 
                                    class="btn btn-primary btn-sm mt-2">Descargar</a>
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
            console.log("Respuesta del servidor:", xhr.responseText);
            $('#constancias-container').append(
                '<div class="alert alert-danger" role="alert">Error al cargar las constancias.</div>'
            );
        }
    });
});
