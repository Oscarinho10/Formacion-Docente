<?php
include('../components/layout.php');

// Conexión a PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "formacion_docente";
$user = "jerss";
$password = "admin";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("❌ Error al conectar con PostgreSQL.");
}

// Consulta para obtener las actividades
$query = "SELECT nombre, duracion, modalidad, cupo FROM actividades";
$result = pg_query($conn, $query);

$actividades = array();
while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        "nombre" => $row["nombre"],
        "horas" => $row["duracion"] . " horas",
        "modalidad" => $row["modalidad"],
        "cupo" => $row["cupo"] . " participantes"
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-actions button {
            margin-right: 5px;
        }

        .table-container {
            margin: 20px auto;
            width: fit-content;
        }
    </style>
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

        <!-- Paginador -->
        <nav>
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Botones de página dinámicos -->
            </ul>
        </nav>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        const data = <?php echo json_encode($actividades); ?>;
        const rowsPerPage = 5;
        let currentPage = 1;

        function renderTable() {
            const search = $('#searchInput').val().toLowerCase();
            const modality = $('#filterModality').val();
            const filtered = data.filter(function(item) {
                return item.nombre.toLowerCase().includes(search) &&
                    (modality === '' || item.modalidad === modality);
            });

            const totalPages = Math.ceil(filtered.length / rowsPerPage);
            const start = (currentPage - 1) * rowsPerPage;
            const visibleData = filtered.slice(start, start + rowsPerPage);

            $('#tableBody').html('');
            visibleData.forEach(function(item, index) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + item.nombre + '</td>' +
                    '<td>' + item.horas + '</td>' +
                    '<td>' + item.modalidad + '</td>' +
                    '<td>' + item.cupo + '</td>' +
                    '<td class="table-actions">' +
                    '<button class="btn btn-sm btn-secondary btn-vermas" ' +
                    'data-nombre="' + item.nombre + '" ' +
                    'data-horas="' + item.horas + '" ' +
                    'data-modalidad="' + item.modalidad + '" ' +
                    'data-cupo="' + item.cupo + '">Ver más</button>' +
                    '<a href="registerActivity.php?curso=' + encodeURIComponent(item.nombre) + '" class="btn btn-sm btn-success">Inscribirme</a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#pagination').html('');
            for (let i = 1; i <= totalPages; i++) {
                $('#pagination').append(
                    '<li class="page-item ' + (i === currentPage ? 'active' : '') + '">' +
                    '<a class="page-link" href="#">' + i + '</a>' +
                    '</li>'
                );
            }

            $('#pagination a').click(function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).text());
                renderTable();
            });

            $('.btn-vermas').click(function() {
                $('#modalNombre').text($(this).data('nombre'));
                $('#modalHoras').text($(this).data('horas'));
                $('#modalModalidad').text($(this).data('modalidad'));
                $('#modalCupo').text($(this).data('cupo'));
                $('#detalleModal').modal('show');
            });
        }

        $('#searchInput, #filterModality').on('input change', function() {
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
    </script>

    <?php include('./modals/modalDetalles.php'); ?>

</body>

</html>
