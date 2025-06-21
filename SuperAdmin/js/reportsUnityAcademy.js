const datos = [
  { anio: 2025, unidad: "Facultad de Ingeniería", actividades: 10, participantes: 250, asistencias: 240 },
  { anio: 2024, unidad: "Facultad de Ciencias", actividades: 8, participantes: 200, asistencias: 190 },
  { anio: 2023, unidad: "Facultad de Arquitectura", actividades: 7, participantes: 180, asistencias: 175 },
  { anio: 2022, unidad: "Facultad de Humanidades", actividades: 5, participantes: 150, asistencias: 148 },
  { anio: 2021, unidad: "Facultad de Derecho", actividades: 6, participantes: 160, asistencias: 159 },
  { anio: 2020, unidad: "Facultad de Medicina", actividades: 4, participantes: 120, asistencias: 110 },
  { anio: 2025, unidad: "Facultad de Ingeniería", actividades: 10, participantes: 250, asistencias: 240 },
  { anio: 2024, unidad: "Facultad de Ciencias", actividades: 8, participantes: 200, asistencias: 190 },
  { anio: 2023, unidad: "Facultad de Arquitectura", actividades: 7, participantes: 180, asistencias: 175 },
  { anio: 2022, unidad: "Facultad de Humanidades", actividades: 5, participantes: 150, asistencias: 148 },
  { anio: 2021, unidad: "Facultad de Derecho", actividades: 6, participantes: 160, asistencias: 159 },
  { anio: 2020, unidad: "Facultad de Medicina", actividades: 4, participantes: 120, asistencias: 110 }
];

function filtrarAnios() {
  const search = document.getElementById("searchInput").value.toLowerCase();
  const anioSeleccionado = document.getElementById("yearSelect").value;

  const filtrados = datos.filter(d =>
    (anioSeleccionado ? d.anio == anioSeleccionado : true) &&
    (!search || d.unidad.toLowerCase().includes(search))
  );

  // Agrupar por año (aunque solo será 1 si seleccionaron uno)
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

  const contenedor = document.getElementById("tbodyAnios");
  contenedor.innerHTML = "";

  // Limpiar tablas previas
  let tablaGenerada = document.getElementById("tablasPorAnio");
  const tablaContenedor = document.getElementById("tablaAnios").parentElement;
  if (!tablaGenerada) {
    tablaGenerada = document.createElement("div");
    tablaGenerada.id = "tablasPorAnio";
    tablaContenedor.appendChild(tablaGenerada);
  }
  tablaGenerada.innerHTML = "";

  if (añosOrdenados.length === 0) {
    tablaGenerada.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados.</td></tr>`;
    return;
  }

  document.getElementById("tablaAnios").style.display = "none";

  let htmlFinal = "";
  añosOrdenados.forEach(anio => {
    htmlFinal += `
      <h5 class="mt-4">${anio}</h5>
      <table class="table table-bordered">
        <thead class="thead-light">
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

    htmlFinal += `</tbody></table>`;
  });

  tablaGenerada.innerHTML = htmlFinal;
}

// Imprimir tabla base (si deseas imprimir solo la original)
function imprimirTabla() {
  const tabla = document.getElementById("tablaAnios").outerHTML;

  const ventana = window.open('', '', 'width=1000,height=700');
  ventana.document.write(`
    <html>
      <head>
        <title>Reporte por unidad académica</title>
        <link rel="stylesheet" href="/assets/css/bootstrap.css">
        <style>
          body { font-family: Arial, sans-serif; padding: 40px; }
          h2 { text-align: center; margin-bottom: 30px; }
          .logo { text-align: center; margin-bottom: 20px; }
          .logo img { height: 60px; }
          table { width: 100%; border-collapse: collapse; margin-top: 20px; }
          th, td { border: 1px solid #ccc; padding: 8px; font-size: 13px; text-align: center; }
          th { background-color: #f5f5f5; }
        </style>
      </head>
      <body>
        <div class="logo">
          <img src="/assets/img/logo.png" alt="Logo institucional">
        </div>
        <h2>Reporte por unidad académica</h2>
        ${tabla}
      </body>
    </html>
  `);
  ventana.document.close();
  ventana.focus();
  ventana.print();
}

// Inicializa con evento
document.addEventListener("DOMContentLoaded", () => {
  filtrarAnios();
  document.getElementById("yearSelect").addEventListener("change", filtrarAnios);
  document.getElementById("searchInput").addEventListener("input", filtrarAnios);
});
