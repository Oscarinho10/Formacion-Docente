let data = [];

// Cargar datos desde el backend
function cargarDatos() {
  fetch('controller/generalReport.php')
    .then(res => res.json())
    .then(res => {
      data = res;
      renderTabla(data);
    })
    .catch(err => {
      console.error("Error cargando reporte:", err);
    });
}

// Renderiza la tabla con los datos
function renderTabla(lista) {
  const tbody = document.getElementById("tbodyReporte");
  tbody.innerHTML = "";

  if (lista.length === 0) {
    tbody.innerHTML = `<tr><td colspan="9" class="text-center">No se encontraron resultados</td></tr>`;
    return;
  }

  lista.forEach(row => {
    tbody.innerHTML += `
      <tr>
        <td>${row.tipo}</td>
        <td>${row.actividad}</td>
        <td>${row.instructor}</td>
        <td>${row.duracion}</td>
        <td>${row.modalidad}</td>
        <td>${row.fecha}</td>
        <td>${row.horario}</td>
        <td>${row.participantes}</td>
        <td>${row.asistidos}</td>
      </tr>
    `;
  });
}

// Aplica filtros
function filtrarTabla() {
  const search = (document.getElementById("searchInput").value || "").toLowerCase();
  const semestre = document.getElementById("semestreSelect").value;
  const anio = document.getElementById("anioSelect").value;

  const filtrados = data.filter(d =>
    (!search || d.actividad.toLowerCase().includes(search)) &&
    (!semestre || d.semestre === semestre) &&
    (!anio || d.anio === anio)
  );

  renderTabla(filtrados);
}

// Limpia filtros y muestra todos los datos
function limpiarFiltros() {
  document.getElementById("searchInput").value = "";
  document.getElementById("semestreSelect").value = "";
  document.getElementById("anioSelect").value = "";
  renderTabla(data);
}

// Exporta el reporte filtrado a PDF
function exportarPDF() {
  const search = (document.getElementById("searchInput").value || "").toLowerCase();
  const semestre = document.getElementById("semestreSelect").value;
  const anio = document.getElementById("anioSelect").value;

  const filtrados = data.filter(d =>
    (!search || d.actividad.toLowerCase().includes(search)) &&
    (!semestre || d.semestre === semestre) &&
    (!anio || d.anio === anio)
  );

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = 'controller/reportController.php';
  form.target = '_blank';

  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'data';
  input.value = JSON.stringify(filtrados);
  form.appendChild(input);

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

// Inicializa eventos al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  cargarDatos();

  document.getElementById("searchInput").addEventListener("input", filtrarTabla);
  document.getElementById("semestreSelect").addEventListener("change", filtrarTabla);
  document.getElementById("anioSelect").addEventListener("change", filtrarTabla);
  document.getElementById("clearFilters").addEventListener("click", limpiarFiltros);
  document.getElementById("btnExportarPDF").addEventListener("click", exportarPDF);
});
