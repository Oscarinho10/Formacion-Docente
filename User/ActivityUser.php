<?php
include('../components/layout.php');
include('../config/conexion.php');

// Consulta para obtener las actividades
$query = "SELECT nombre, duracion, modalidad, cupo, lugar, tipo, fecha_inicio, fecha_fin, dirigido_a, horario FROM actividades";

$result = pg_query($conn, $query);

$actividades = array();
while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        "nombre" => $row["nombre"],
        "horas" => $row["duracion"] . " horas",
        "modalidad" => $row["modalidad"],
        "cupo" => $row["cupo"] . " participantes",
        "lugar" => $row["lugar"],
        "tipo" => $row["tipo"],
        "fecha_inicio" => $row["fecha_inicio"],
        "fecha_fin" => $row["fecha_fin"],
        "dirigido_a" => $row["dirigido_a"],
        "horario" => $row["horario"]
    );
}

// Consulta para obtener las modalidades únicas
$modalidad_query = "SELECT DISTINCT modalidad FROM actividades";
$modalidad_result = pg_query($conn, $modalidad_query);

$modalidades = array();
while ($row = pg_fetch_assoc($modalidad_result)) {
    $modalidades[] = $row["modalidad"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla con filtros</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <!-- Filtros -->
        <div class="form-row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar curso...">
                </div>
            </div>

            <div class="col-md-3">
                <select class="form-control" id="filterModality">
                    <option value="">Todas las modalidades</option>
                    <?php foreach ($modalidades as $modo): ?>
                        <option value="<?php echo htmlspecialchars($modo); ?>"><?php echo htmlspecialchars($modo); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-outline-secondary" id="clearFilters">Limpiar filtros</button>
            </div>
        </div>

        <!-- Contenedor para centrar la tabla -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="coursesTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre del curso</th>
                            <th>Total de horas</th>
                            <th>Modalidad</th>
                            <th>Cupo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginador y contador -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="pagination-info" id="paginationInfo">
                Mostrando 1-5 de <?php echo count($actividades); ?> registros
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Botones de página dinámicos -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>

    <script>
        const data = <?php echo json_encode($actividades); ?>;
        const rowsPerPage = 5;
        let currentPage = 1;
        let filtered = [...data];

        function renderTable() {
            const search = $('#searchInput').val().toLowerCase();
            const modalityFilter = $('#filterModality').val();

            // Filtrar datos
            filtered = data.filter(function(item) {
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
            $.each(visibleData, function(index, item) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + item.nombre + '</td>' +
                    '<td>' + item.horas + '</td>' +
                    '<td>' + item.modalidad + '</td>' +
                    '<td>' + item.cupo + '</td>' +
                    '<td class="table-actions">' +
                    '<button class="btn btn-sm btn-secondary btn-vermas" ' +
                    'data-lugar="' + item.lugar + '" ' +
                    'data-tipo="' + item.tipo + '" ' +
                    'data-inicio="' + item.fecha_inicio + '" ' +
                    'data-fin="' + item.fecha_fin + '" ' +
                    'data-dirigido="' + item.dirigido_a + '" ' +
                    'data-horario="' + item.horario + '">Ver más</button>' +
                    '<a href="registerActivity.php?curso=' + encodeURIComponent(item.nombre) + '" class="btn btn-sm btn-success">Inscribirme</a>' +
                    '</td>' +
                    '</tr>'
                );
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
            $('#pagination a').not('#prevPage, #nextPage').click(function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).text());
                renderTable();
            });

            $('#prevPage').click(function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            $('#nextPage').click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });
        }

        // Eventos para filtros
        $('#searchInput').on('input', function() {
            currentPage = 1;
            renderTable();
        });

        $('#filterModality').change(function() {
            currentPage = 1;
            renderTable();
        });

        $('#clearFilters').click(function() {
            $('#searchInput').val('');
            $('#filterModality').val('');
            currentPage = 1;
            renderTable();
        });

        $(document).ready(function() {
            renderTable();
        });

        $('.btn-vermas').click(function() {
            $('#modalLugar').text($(this).data('lugar'));
            $('#modalTipo').text($(this).data('tipo'));
            $('#modalInicio').text($(this).data('inicio'));
            $('#modalFin').text($(this).data('fin'));
            $('#modalDirigido').text($(this).data('dirigido'));
            $('#modalHorario').text($(this).data('horario'));

            $('#detalleModal').modal('show');
        });
    </script>

    <?php include('./modals/modalDetalles.php'); ?>

</body>

</html>
