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