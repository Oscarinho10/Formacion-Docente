<?php include('../components/layoutSuper.php') ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Docentes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h4 class="mb-3">Instructores </h4>

    <!-- Filtro -->
    <div class="form-row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre...">
            </div>
        </div>
         <div class="col-md-6 text-right">
                <a class="btn btn-primary" id="addButton" href="addInstructor.php"> + Agregar</a>
            </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-bordered" id="professorsTable">
            <thead class="thead-light">
                <tr>
                    <th>Nombre</th>
                    <th>Perfil Académico</th>
                    <th>Unidad Académica</th>
                    <th>Cupo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Contenido dinámico -->
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div id="paginationInfo"></div>
        <ul class="pagination" id="pagination"></ul>
    </div>

</div>

<!-- Scripts -->
<script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>

<script>
    const data = [
        { nombre: "Dr. Ana Torres", perfil: "Ingeniería en Software", unidad: "Facultad de Ingeniería", cupo: 30 },
        { nombre: "Mtro. Luis Rivas", perfil: "Matemáticas Aplicadas", unidad: "Facultad de Ciencias", cupo: 25 },
        { nombre: "Lic. Marta León", perfil: "Comunicación", unidad: "Facultad de Humanidades", cupo: 20 },
        { nombre: "Dra. Claudia Díaz", perfil: "Biología Molecular", unidad: "Facultad de Ciencias Naturales", cupo: 15 },
        { nombre: "Mtro. Pedro Jiménez", perfil: "Arquitectura", unidad: "Facultad de Arquitectura", cupo: 28 },
        { nombre: "Ing. Julio Suárez", perfil: "Sistemas Computacionales", unidad: "Facultad de Ingeniería", cupo: 35 },
        { nombre: "Lic. Karen López", perfil: "Diseño Gráfico", unidad: "Facultad de Artes", cupo: 22 }
    ];

    const rowsPerPage = 5;
    let currentPage = 1;
    let filtered = [...data];

    function renderTable() {
        const search = $('#searchInput').val().toLowerCase();

        filtered = data.filter(item =>
            item.nombre.toLowerCase().includes(search) ||
            item.perfil.toLowerCase().includes(search) ||
            item.unidad.toLowerCase().includes(search)
        );

        const totalPages = Math.ceil(filtered.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = Math.min(start + rowsPerPage, filtered.length);
        const visibleData = filtered.slice(start, end);

        $('#paginationInfo').text(`Mostrando ${start + 1}-${end} de ${filtered.length} registros`);
        $('#tableBody').html('');

        visibleData.forEach(item => {
            $('#tableBody').append(`
                <tr>
                    <td>${item.nombre}</td>
                    <td>${item.perfil}</td>
                    <td>${item.unidad}</td>
                    <td>${item.cupo}</td>
                    <td class="text-center acciones">
                        <button class="btn btn-sm btn-general" onclick="window.location.href='editInstructor.php'">Editar</button>
                    </td>
                </tr>
            `);
        });

        $('#pagination').html('');
        if (totalPages > 1) {
            $('#pagination').append(`
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" id="prevPage">&laquo;</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                $('#pagination').append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#">${i}</a>
                    </li>
                `);
            }

            $('#pagination').append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" id="nextPage">&raquo;</a>
                </li>
            `);
        }

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

    $('#searchInput').on('input', function () {
        currentPage = 1;
        renderTable();
    });

    $(document).ready(function () {
        renderTable();
    });
</script>

</body>
</html>
