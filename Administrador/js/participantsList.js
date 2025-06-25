const data = [
  { nombre: "Juan Perez", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Oscar Maydon", fechas: ["Asistió", "No asistió", "No asistió", "No asistió"], constancia: "No" },
  { nombre: "Giovanni Pedraza", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "No" },
  { nombre: "Alejandro Morales", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Juan Perez", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Oscar Maydon", fechas: ["Asistió", "No asistió", "No asistió", "No asistió"], constancia: "No" },
  { nombre: "Giovanni Pedraza", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "No" },
  { nombre: "Alejandro Morales", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Juan Perez", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Oscar Maydon", fechas: ["Asistió", "No asistió", "No asistió", "No asistió"], constancia: "No" },
  { nombre: "Giovanni Pedraza", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "No" },
  { nombre: "Alejandro Morales", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Juan Perez", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
  { nombre: "Oscar Maydon", fechas: ["Asistió", "No asistió", "No asistió", "No asistió"], constancia: "No" },
  { nombre: "Giovanni Pedraza", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "No" },
  { nombre: "Alejandro Morales", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" }
];

let currentPage = 1;
const rowsPerPage = 5;

function renderTable(filteredData, page = 1) {
  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedData = filteredData.slice(start, end);

  const body = document.getElementById('asistenciaBody');
  body.innerHTML = "";

  if (paginatedData.length === 0) {
    body.innerHTML = `<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>`;
  } else {
    paginatedData.forEach(item => {
      const row = `
        <tr>
          <td>${item.nombre}</td>
          <td>${item.fechas[0]}</td>
          <td>${item.fechas[1]}</td>
          <td>${item.fechas[2]}</td>
          <td>${item.fechas[3]}</td>
          <td>${item.constancia}</td>
        </tr>
      `;
      body.innerHTML += row;
    });
  }

  renderPagination(filteredData.length, page);
}

function renderPagination(totalItems, page) {
  const totalPages = Math.ceil(totalItems / rowsPerPage);
  const pagination = document.getElementById("pagination");
  const paginationInfo = document.getElementById("paginationInfo");

  pagination.innerHTML = "";
  paginationInfo.textContent = `Página ${page} de ${totalPages || 1}`;

  // Flecha anterior
  const prev = document.createElement("li");
  prev.className = `page-item ${page === 1 ? 'disabled' : ''}`;
  prev.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
  prev.addEventListener("click", (e) => {
    e.preventDefault();
    if (page > 1) renderTable(getFilteredData(), page - 1);
  });
  pagination.appendChild(prev);

  // Números de página
  for (let i = 1; i <= totalPages; i++) {
    const li = document.createElement("li");
    li.className = `page-item ${i === page ? 'active' : ''}`;
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    li.addEventListener("click", (e) => {
      e.preventDefault();
      renderTable(getFilteredData(), i);
    });
    pagination.appendChild(li);
  }

  // Flecha siguiente
  const next = document.createElement("li");
  next.className = `page-item ${page === totalPages ? 'disabled' : ''}`;
  next.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
  next.addEventListener("click", (e) => {
    e.preventDefault();
    if (page < totalPages) renderTable(getFilteredData(), page + 1);
  });
  pagination.appendChild(next);
}

function getFilteredData() {
  const filter = document.getElementById('searchInput').value.toLowerCase();
  return data.filter(d => d.nombre.toLowerCase().includes(filter));
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('searchInput').addEventListener('input', () => {
    currentPage = 1;
    renderTable(getFilteredData(), currentPage);
  });

  renderTable(data, currentPage);
});
