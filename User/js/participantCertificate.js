$(document).ready(function () {
    // Asegúrate que usuarioId venga del HTML y no se defina aquí
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
                    container.append(
                        '<div class="card mb-3">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">Constancia ID: ' + constancia.id_constancia + '</h5>' +
                        '<p class="card-text"><strong>Folio:</strong> ' + constancia.folio + '</p>' +
                        '<p class="card-text"><strong>Fecha de emisión:</strong> ' + constancia.fecha_emision + '</p>' +
                        (constancia.qr_url ? '<img src="' + constancia.qr_url + '" width="100">' : '') +
                        '</div>' +
                        '</div>'
                    );
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
