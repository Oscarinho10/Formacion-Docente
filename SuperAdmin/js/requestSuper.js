const data = [{
                nombre: "Ana Pérez",
                control: "21001234",
                correo: "ana.perez@ejemplo.com",
                perfil: "Ingeniería en Sistemas"
            },
            {
                nombre: "Luis Gómez",
                control: "21005678",
                correo: "luis.gomez@ejemplo.com",
                perfil: "Arquitectura"
            },
            {
                nombre: "María López",
                control: "21009876",
                correo: "maria.lopez@ejemplo.com",
                perfil: "Contaduría"
            },
            {
                nombre: "Juan Herrera",
                control: "21002345",
                correo: "juan.herrera@ejemplo.com",
                perfil: "Diseño Gráfico"
            },
            {
                nombre: "Laura Martínez",
                control: "21006789",
                correo: "laura.martinez@ejemplo.com",
                perfil: "Psicología"
            },
            {
                nombre: "Carlos Ramírez",
                control: "21003456",
                correo: "carlos.ramirez@ejemplo.com",
                perfil: "Medicina"
            },
            {
                nombre: "Daniela Torres",
                control: "21007890",
                correo: "daniela.torres@ejemplo.com",
                perfil: "Administración"
            }
        ];

        const rowsPerPage = 5;
        let currentPage = 1;
        let filtered = [...data];

        function renderTable() {
            const search = $('#searchInput').val().toLowerCase();

            filtered = data.filter(item =>
                item.nombre.toLowerCase().includes(search) ||
                item.control.toLowerCase().includes(search) ||
                item.correo.toLowerCase().includes(search) ||
                item.perfil.toLowerCase().includes(search)
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
                    <td>${item.control}</td>
                    <td>${item.correo}</td>
                    <td>${item.perfil}</td>
                    <td>
                        <button class="btn btn-sm btn-general">Aceptar</button>
                        <button class="btn btn-sm btn-danger">Denegar</button>
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