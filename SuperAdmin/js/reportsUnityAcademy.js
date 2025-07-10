let datos = [];

async function cargarDatosUnidadAcademica() {
  try {
    const res = await fetch("controller/reportsUnityAcademyController.php");
    datos = await res.json();
    filtrarAnios();
  } catch (error) {
    console.error("Error al cargar datos:", error);
  }
}

function filtrarAnios() {
  const search = document.getElementById("searchInput").value.toLowerCase();
  const anioSeleccionado = document.getElementById("yearSelect").value;

  const filtrados = datos.filter(d =>
    (!anioSeleccionado || d.anio == anioSeleccionado) &&
    (!search || d.unidad.toLowerCase().includes(search))
  );

  const agrupadoPorAnio = {};
  filtrados.forEach(dato => {
    if (!agrupadoPorAnio[dato.anio]) {
      agrupadoPorAnio[dato.anio] = [];
    }
    agrupadoPorAnio[dato.anio].push(dato);
  });

  const añosOrdenados = Object.keys(agrupadoPorAnio)
    .map(Number)
    .sort((a, b) => b - a);

  const tablaContenedor = document.getElementById("tablaAnios").parentElement;
  let tablaGenerada = document.getElementById("tablasPorAnio");

  if (!tablaGenerada) {
    tablaGenerada = document.createElement("div");
    tablaGenerada.id = "tablasPorAnio";
    tablaContenedor.appendChild(tablaGenerada);
  }

  tablaGenerada.innerHTML = "";

  if (añosOrdenados.length === 0) {
    tablaGenerada.innerHTML = `<div class="mt-3 text-center">No se encontraron resultados.</div>`;
    document.getElementById("tablaAnios").style.display = "none";
    return;
  }

  document.getElementById("tablaAnios").style.display = "none";

  let htmlFinal = "";
  añosOrdenados.forEach(anio => {
    htmlFinal += `
      <div class="reporte-por-anio">
        <h5 class="mt-4">${anio}</h5>
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Unidad Académica</th>
              <th>Actividades Realizadas</th>
              <th>Total Participantes</th>
              <th>Total Asistencias</th>
            </tr>
          </thead>
          <tbody>
    `;

    agrupadoPorAnio[anio].forEach(item => {
      htmlFinal += `
        <tr>
          <td>${item.unidad}</td>
          <td>${item.actividades}</td>
          <td>${item.participantes}</td>
          <td>${item.asistencias}</td>
        </tr>
      `;
    });

    htmlFinal += `</tbody></table></div>`;
  });

  tablaGenerada.innerHTML = htmlFinal;
}

function exportarReporteActividadPDF() {
  const search = document.getElementById("searchInput").value.toLowerCase();
  const anioSeleccionado = document.getElementById("yearSelect").value;

  const filtrados = datos.filter(d =>
    (!anioSeleccionado || d.anio == anioSeleccionado) &&
    (!search || d.unidad.toLowerCase().includes(search))
  );

  if (filtrados.length === 0) {
    alert("No hay datos para exportar");
    return;
  }

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = 'controller/reportPdfUnitAcademy.php';
  form.target = '_blank';

  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'data';
  input.value = encodeURIComponent(JSON.stringify(filtrados)); // Codificamos para asegurar
  form.appendChild(input);

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

document.addEventListener("DOMContentLoaded", () => {
  cargarDatosUnidadAcademica();
  document.getElementById("yearSelect").addEventListener("change", filtrarAnios);
  document.getElementById("searchInput").addEventListener("input", filtrarAnios);
  document.getElementById("btnExportarActividad").addEventListener("click", exportarReporteActividadPDF);
});
