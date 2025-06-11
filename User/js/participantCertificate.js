$(document).ready(function() {
            // Cambia esto por el ID real del usuario participante (puede venir de sesión)
            var usuarioId = 123;

            $.ajax({
                url: 'getCertificate.php',
                type: 'GET',
                data: {
                    usuario_id: usuarioId
                },
                dataType: 'json',
                success: function(data) {
                    var container = $('#constancias-container');
                    if (data.length > 0) {
                        data.forEach(function(constancia) {
                            container.append(
                                '<div class="card mb-3">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">Constancia ID: ' + constancia.id + '</h5>' +
                                '<p class="card-text">Folio: ' + constancia.folio + '</p>' +
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
                error: function(xhr, status, error) {
                    $('#constancias-container').append(
                        '<div class="alert alert-danger" role="alert">Error al cargar las constancias.</div>'
                    );
                }
            });
        });