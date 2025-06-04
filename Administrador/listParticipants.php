<?php
include('../components/layout.php');
include('../config/conexion.php');

// Consulta para obtener usuarios con rol "usuario" y estado "pendiente"
$query = "SELECT nombre, apellido_paterno, apellido_materno, numero_control_rfc, correo 
          FROM usuarios 
          WHERE rol = 'usuario' AND estado = 'pendiente'";

$result = pg_query($conn, $query);

$usuarios = array();
while ($row = pg_fetch_assoc($result)) {
    $usuarios[] = array(
        "nombre" => $row["nombre"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"],
        "numero_control_rfc" => $row["numero_control_rfc"],
        "correo" => $row["correo"]  
    );
}
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
    </style>
</head>

<body class="bg-light">

    <div class="container mt-4">

        <!-- Filtros -->
        <div class="form-row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre o número de control...">
                </div>
            </div>

            <div class="col-md-3">
                <button class="btn btn-outline-secondary" id="clearFilters">Limpiar filtros</button>
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
            
            // Filtrar datos
            filtered = data.filter(item => 
                item.nombre.toLowerCase().includes(search) || 
                item.numero_control_rfc.toLowerCase().includes(search) ||
                item.correo.toLowerCase().includes(search)
            );

            const totalPages = Math.ceil(filtered.length / rowsPerPage);
            const start = (currentPage - 1) * rowsPerPage;
            const end = Math.min(start + rowsPerPage, filtered.length);
            const visibleData = filtered.slice(start, end);

            // Actualizar información de paginación
            $('#paginationInfo').html(`Mostrando ${start+1}-${end} de ${filtered.length} registros`);

            $('#tableBody').html('');
            visibleData.forEach(function(item) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + item.nombre + '</td>' +
                    '<td>' + item.numero_control_rfc + '</td>' +
                    '<td>' + item.correo + '</td>' +
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
                for (let i = 1; i <= totalPages; i++) {
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
                const row = $(this).closest('tr');
                const controlNumber = row.find('td:eq(1)').text();
                // Aquí iría la lógica para aceptar al usuario
                console.log('Aceptar usuario con número de control:', controlNumber);
                // row.fadeOut();
            });

            $('.btn-deny').click(function() {
                const row = $(this).closest('tr');
                const controlNumber = row.find('td:eq(1)').text();
                // Aquí iría la lógica para denegar al usuario
                console.log('Denegar usuario con número de control:', controlNumber);
                // row.fadeOut();
            });
        }

        $('#searchInput').on('input', function() {
            currentPage = 1;
            renderTable();
        });

        $('#clearFilters').click(function() {
            $('#searchInput').val('');
            currentPage = 1;
            renderTable();
        });

        $(document).ready(function() {
            renderTable();
        });
    </script>

</body>

</html>