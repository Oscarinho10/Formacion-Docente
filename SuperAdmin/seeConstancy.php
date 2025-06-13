<?php
include('../components/layoutSuper.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Generar Constancias</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
</head>

<body class="bg-light">
    <div class="container mt-4 d-flex justify-content-center">
        <div style="width: 100%; max-width: 1000px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Generar Constancias</h3>
            </div>

            <!-- Filtros de búsqueda -->
            <div class="form-row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar participante...">
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="date" id="filterFecha" class="form-control">
                </div>
            </div>

            <!-- Tabla de Participantes -->
            <div class="table-responsive">
                <table class="table table-bordered" id="studentsTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Rellenado por JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-primary" id="generateAllButton">Generar Constancias de Todos</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>

    <script>
        // Datos estáticos de estudiantes (simulados)
        const estudiantes = [
            { nombre: "Juan Pérez", correo: "juan@example.com", curso: "Curso de IA" },
            { nombre: "Maria López", correo: "maria@example.com", curso: "Curso de IA" }
        ];

        // Renderizar tabla de estudiantes
        function renderTable() {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            estudiantes.forEach(estudiante => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${estudiante.nombre}</td>
                    <td>${estudiante.correo}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="generarConstancia('${estudiante.correo}')">Generar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Llamada a generar constancia individual
        function generarConstancia(correo) {
            // Aquí se generaría la constancia para el estudiante
            alert(`Generando constancia para: ${correo}`);
            // Redirigir al archivo PHP de generación de constancia
            window.location.href = `./controller/generateConstancy.php?correo=${correo}`;
        }

        // Llamada a generar constancias para todos
        function generarConstanciasTodos() {
            estudiantes.forEach(est => {
                // Llamar a generar constancia para cada estudiante
                generarConstancia(est.correo);
            });
        }

        // Inicializar tabla
        renderTable();

        // Evento para generar constancias de todos los participantes
        document.getElementById('generateAllButton').addEventListener('click', function() {
            generarConstanciasTodos();
        });

        // Evento de filtro de búsqueda
        document.getElementById('searchInput').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            const filteredEstudiantes = estudiantes.filter(est => est.nombre.toLowerCase().includes(search));
            renderTable(filteredEstudiantes);
        });
    </script>
</body>

</html>
