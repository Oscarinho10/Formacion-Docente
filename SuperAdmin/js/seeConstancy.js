// Datos estáticos de estudiantes (simulados)
const estudiantes = [
    { nombre: "Juan Pérez", correo: "juan@example.com", curso: "Curso de IA" },
    { nombre: "Maria López", correo: "maria@example.com", curso: "Curso de IA" },
     { nombre: "Juana   Martinez", correo: "juan@example.com", curso: "Curso de IA" },
    { nombre: "Maria López Perez", correo: "maria@example.com", curso: "Curso de Figma " }
];

// Función para renderizar la tabla
function renderTable(lista = estudiantes) {
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';

    lista.forEach(estudiante => {
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

// Generar constancia individual
function generarConstancia(correo) {
    alert(`Generando constancia para: ${correo}`);
    window.location.href = `./controller/generateConstancy.php?correo=${correo}`;
}

// Generar constancias para todos
function generarConstanciasTodos() {
    estudiantes.forEach(est => {
        generarConstancia(est.correo);
    });
}

// Evento: botón "Generar todos"
document.getElementById('generateAllButton').addEventListener('click', function () {
    generarConstanciasTodos();
});

// Evento: filtro por nombre
document.getElementById('searchInput').addEventListener('input', function () {
    const search = this.value.toLowerCase();
    const filteredEstudiantes = estudiantes.filter(est =>
        est.nombre.toLowerCase().includes(search)
    );
    renderTable(filteredEstudiantes);
});

// Evento: limpiar filtros
document.getElementById('clearFiltersBtn').addEventListener('click', function () {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterFecha').value = '';
    renderTable(); // Muestra todo de nuevo
});

// Inicializar tabla al cargar
renderTable();
