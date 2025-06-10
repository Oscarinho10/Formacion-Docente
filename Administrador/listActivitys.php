<?php
include('../components/layoutAdmin.php');
// include('../config/conexion.php');

// Consulta modificada para incluir los nuevos campos -->
// $query = "SELECT nombre, apellido_paterno, apellido_materno, numero_control_rfc, correo, 
//                  perfil_academico, unidad_academica 
//           FROM usuarios 
//           WHERE rol = 'participante' AND estado = 'pendiente'";

// $result = pg_query($conn, $query);

// $usuarios = array();
// $unidades = array();
// $perfiles = array();

// while ($row = pg_fetch_assoc($result)) {
//     $usuario = array(
//         "nombre" => $row["nombre"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"],
//         "numero_control_rfc" => $row["numero_control_rfc"],
//         "correo" => $row["correo"],
//         "perfil_academico" => $row["perfil_academico"],
//         "unidad_academica" => $row["unidad_academica"]
//     );
//     $usuarios[] = $usuario;

// Recolectar unidades académicas únicas -->
// if (!empty($row["unidad_academica"]) && !in_array($row["unidad_academica"], $unidades)) {
//     $unidades[] = $row["unidad_academica"];
// }

// Recolectar perfiles académicos únicos -->
//     if (!empty($row["perfil_academico"]) && !in_array($row["perfil_academico"], $perfiles)) {
//         $perfiles[] = $row["perfil_academico"];
//     }
// }

// Ordenar las listas --> 
// sort($unidades);
// sort($perfiles);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Usuarios</title>
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

        <h4 class="mb-3">Actividades formativas</h4>

        <!-- Filtros  -->
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
                    <?php foreach ($unidades as $unidad): ?>
                        <option value="<?php echo htmlspecialchars($unidad); ?>"><?php echo htmlspecialchars($unidad); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <select class="form-control" id="filterPerfil">
                    <option value="">Todos los perfiles</option>
                    <option value="">Perfil de facebook</option>
                    <?php foreach ($perfiles as $perfil): ?>
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
                            <th>Perfil Académico</th>
                            <th>Unidad Académica</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td>Alejandro Morales</td>
                            <td><strong>89567</strong></td>
                            <td>AlejandroMorales@example.com</td>
                            <td class="text-center acciones">
                                <button class="btn btn-sm btn-light">Ver más</button>
                                <button class="btn btn-sm btn-success">+ Asistencia</button>
                            </td>
                        </tr>
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
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>

    <script>
        const data = <?php echo json_encode($usuarios); ?>;
        const rowsPerPage = 5;
        let currentPage = 1;
        let filtered = [...data];

        function renderTable() {
            const search = $('#searchInput').val().toLowerCase();
            const unidadFilter = $('#filterUnidad').val();
            const perfilFilter = $('#filterPerfil').val();

            filtered = data.filter(function(item) {
                var matchesSearch =
                    item.nombre.toLowerCase().includes(search) ||
                    item.numero_control_rfc.toLowerCase().includes(search) ||
                    item.correo.toLowerCase().includes(search);

                var matchesUnidad = !unidadFilter || item.unidad_academica === unidadFilter;
                var matchesPerfil = !perfilFilter || item.perfil_academico === perfilFilter;

                return matchesSearch && matchesUnidad && matchesPerfil;
            });

            var totalPages = Math.ceil(filtered.length / rowsPerPage);
            var start = (currentPage - 1) * rowsPerPage;
            var end = Math.min(start + rowsPerPage, filtered.length);
            var visibleData = filtered.slice(start, end);

            $('#paginationInfo').html(`Mostrando ${start + 1}-${end} de ${filtered.length} registros`);
            $('#tableBody').html('');

            $.each(visibleData, function(index, item) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + item.nombre + '</td>' +
                    '<td>' + (item.perfil_academico || 'N/A') + '</td>' +
                    '<td>' + (item.unidad_academica || 'N/A') + '</td>' +
                    '<td><button class="btn btn-success btn-action btn-edit">Editar</button></td>' +
                    '</tr>'
                );
            });

            // Paginar...
            $('#pagination').html('');
            if (totalPages > 1) {
                $('#pagination').append(
                    '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '">' +
                    '<a class="page-link" href="#" aria-label="Previous" id="prevPage">' +
                    '<span aria-hidden="true">&laquo;</span></a></li>'
                );

                for (let i = 1; i <= totalPages; i++) {
                    $('#pagination').append(
                        '<li class="page-item ' + (i === currentPage ? 'active' : '') + '">' +
                        '<a class="page-link" href="#">' + i + '</a></li>'
                    );
                }

                $('#pagination').append(
                    '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '">' +
                    '<a class="page-link" href="#" aria-label="Next" id="nextPage">' +
                    '<span aria-hidden="true">&raquo;</span></a></li>'
                );
            }

            // Eventos
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

            $('.btn-edit').click(function() {
                const nombre = $(this).closest('tr').find('td:eq(0)').text();
                console.log('Editar usuario:', nombre);
                // Aquí puedes llamar a tu modal o redirección
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