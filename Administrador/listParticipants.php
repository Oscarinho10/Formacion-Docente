<?php
include('../components/layout.php');
include('../config/conexion.php');

// Consulta modificada para incluir los nuevos campos
$query = "SELECT nombre, apellido_paterno, apellido_materno, numero_control_rfc, correo, 
                 perfil_academico, unidad_academica 
          FROM usuarios 
          WHERE rol = 'usuario' AND estado = 'pendiente'";

$result = pg_query($conn, $query);

$usuarios = array();
$unidades = array();
$perfiles = array();

while ($row = pg_fetch_assoc($result)) {
    $usuario = array(
        "nombre" => $row["nombre"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"],
        "numero_control_rfc" => $row["numero_control_rfc"],
        "correo" => $row["correo"],
        "perfil_academico" => $row["perfil_academico"],
        "unidad_academica" => $row["unidad_academica"]
    );
    $usuarios[] = $usuario;
    
    // Recolectar unidades académicas únicas
    if (!empty($row["unidad_academica"]) && !in_array($row["unidad_academica"], $unidades)) {
        $unidades[] = $row["unidad_academica"];
    }
    
    // Recolectar perfiles académicos únicos
    if (!empty($row["perfil_academico"]) && !in_array($row["perfil_academico"], $perfiles)) {
        $perfiles[] = $row["perfil_academico"];
    }
}

// Ordenar las listas
sort($unidades);
sort($perfiles);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-container {
            margin: 20px auto;
            width: 100%;
            max-width: 1200px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table th, .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .btn-action {
            padding: 5px 10px;
            margin: 0 3px;
            font-size: 14px;
        }

        .pagination-info {
            margin-top: 10px;
            text-align: center;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        /* Estilos para los select */
        .form-control {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        /* Asegurar que los filtros se vean bien en móviles */
        @media (max-width: 768px) {
            .form-row > div {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-4">

        <!-- Filtros mejorados -->
        <div class="form-row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar general...">
                </div>
            </div>
            
            <div class="col-md-3">
                <select class="form-control" id="filterUnidad">
                    <option value="">Todas las unidades</option>
                    <option value="">Derecho</option>
                    <?php foreach($unidades as $unidad): ?>
                        <option value="<?php echo htmlspecialchars($unidad); ?>"><?php echo htmlspecialchars($unidad); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <select class="form-control" id="filterPerfil">
                    <option value="">Todos los perfiles</option>
                    <option value="">Perfil de facebook</option>
                    <?php foreach($perfiles as $perfil): ?>
                        <option value="<?php echo htmlspecialchars($perfil); ?>"><?php echo htmlspecialchars($perfil); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <button class="btn btn-outline-secondary btn-block" id="clearFilters">Limpiar filtros</button>
            </div>
        </div>

        <!-- Contenedor de la tabla -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Número de control / RFC</th>
                            <th>Correo electrónico</th>
                            <th>Perfil Académico</th>
                            <th>Unidad Académica</th>
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
                Mostrando 1-5 de <?php echo count($usuarios); ?> registros
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Botones de página dinámicos -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        const data = <?php echo json_encode($usuarios); ?>;
        const rowsPerPage = 5;
        let currentPage = 1;
        let filtered = [...data];

        function renderTable() {
            const search = $('#searchInput').val().toLowerCase();
            const unidadFilter = $('#filterUnidad').val();
            const perfilFilter = $('#filterPerfil').val();
            
            // Filtrar datos
            filtered = data.filter(function(item) {
                var matchesSearch = 
                    item.nombre.toLowerCase().indexOf(search) !== -1 || 
                    item.numero_control_rfc.toLowerCase().indexOf(search) !== -1 ||
                    item.correo.toLowerCase().indexOf(search) !== -1;
                
                var matchesUnidad = !unidadFilter || item.unidad_academica === unidadFilter;
                var matchesPerfil = !perfilFilter || item.perfil_academico === perfilFilter;
                
                return matchesSearch && matchesUnidad && matchesPerfil;
            });

            var totalPages = Math.ceil(filtered.length / rowsPerPage);
            var start = (currentPage - 1) * rowsPerPage;
            var end = Math.min(start + rowsPerPage, filtered.length);
            var visibleData = filtered.slice(start, end);

            // Actualizar información de paginación
            $('#paginationInfo').html('Mostrando ' + (start+1) + '-' + end + ' de ' + filtered.length + ' registros');

            $('#tableBody').html('');
            $.each(visibleData, function(index, item) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + item.nombre + '</td>' +
                    '<td>' + item.numero_control_rfc + '</td>' +
                    '<td>' + item.correo + '</td>' +
                    '<td>' + (item.perfil_academico || 'N/A') + '</td>' +
                    '<td>' + (item.unidad_academica || 'N/A') + '</td>' +
                    '<td>' +
                    '<button class="btn btn-success btn-action btn-accept">Aceptar</button>' +
                    '<button class="btn btn-danger btn-action btn-deny">Denegar</button>' +
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

            // Eventos para botones de acción
            $('.btn-accept').click(function() {
                var row = $(this).closest('tr');
                var controlNumber = row.find('td:eq(1)').text();
                // Aquí iría la lógica para aceptar al usuario
                console.log('Aceptar usuario con número de control:', controlNumber);
                // row.fadeOut();
            });

            $('.btn-deny').click(function() {
                var row = $(this).closest('tr');
                var controlNumber = row.find('td:eq(1)').text();
                // Aquí iría la lógica para denegar al usuario
                console.log('Denegar usuario con número de control:', controlNumber);
                // row.fadeOut();
            });
        }

        // Eventos para filtros
        $('#searchInput').on('input', function() {
            currentPage = 1;
            renderTable();
        });

        $('#filterUnidad, #filterPerfil').change(function() {
            currentPage = 1;
            renderTable();
        });

        $('#clearFilters').click(function() {
            $('#searchInput').val('');
            $('#filterUnidad, #filterPerfil').val('');
            currentPage = 1;
            renderTable();
        });

        $(document).ready(function() {
            renderTable();
        });
    </script>

</body>

</html>