const data = [
  {
    tipo: "Curso",
    actividad: "Liderazgo Organizacional",
    instructor: "Dr. Ana Torres",
    duracion: "20h",
    modalidad: "Presencial",
    fecha: "2023-03-15",
    horario: "10:00 - 14:00",
    participantes: 30,
    asistidos: 28,
    semestre: "Enero - Junio",
    anio: "2023"
  },
  {
    tipo: "Taller",
    actividad: "Innovación Educativa",
    instructor: "Mtro. Luis Rivas",
    duracion: "16h",
    modalidad: "Virtual",
    fecha: "2023-08-01",
    horario: "09:00 - 13:00",
    participantes: 25,
    asistidos: 23,
    semestre: "Julio - Diciembre",
    anio: "2023"
  },
  {
    tipo: "Diplomado",
    actividad: "Gestión Pública",
    instructor: "Dra. Claudia Díaz",
    duracion: "40h",
    modalidad: "Mixta",
    fecha: "2024-02-10",
    horario: "08:00 - 12:00",
    participantes: 40,
    asistidos: 38,
    semestre: "Enero - Junio",
    anio: "2024"
  }
];

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

function filtrarTabla() {
  const search = document.getElementById("searchInput").value.toLowerCase();
  const semestre = document.getElementById("semestreSelect").value;
  const anio = document.getElementById("anioSelect").value;

  const filtrados = data.filter(d =>
    (!search || d.actividad.toLowerCase().includes(search)) &&
    (!semestre || d.semestre === semestre) &&
    (!anio || d.anio === anio)
  );

  renderTabla(filtrados);
}

function limpiarFiltros() {
  document.getElementById("searchInput").value = "";
  document.getElementById("semestreSelect").value = "";
  document.getElementById("anioSelect").value = "";
  renderTabla(data);
}

document.addEventListener("DOMContentLoaded", () => {
  renderTabla(data);

  document.getElementById("searchInput").addEventListener("input", filtrarTabla);
  document.getElementById("semestreSelect").addEventListener("change", filtrarTabla);
  document.getElementById("anioSelect").addEventListener("change", filtrarTabla);
  document.getElementById("clearFilters").addEventListener("click", limpiarFiltros);
});

function imprimirReporte() {
  const tabla = document.getElementById("tablaReporte").outerHTML;
  const fechaImpresion = new Date().toLocaleDateString();

  const search = document.getElementById("searchInput").value.trim();
  const semestre = document.getElementById("semestreSelect").value;
  const anio = document.getElementById("anioSelect").value;

  const filtrosAplicados = `
    <div style="margin-top: 20px; font-size: 14px;">
      <strong>Filtros aplicados:</strong><br>
      Búsqueda: ${search || "Todos"}<br>
      Semestre: ${semestre || "Todos"}<br>
      Año: ${anio || "Todos"}
    </div>
  `;

  const ventana = window.open('', '', 'height=700,width=1000');
  ventana.document.write(`
    <html>
    <head>
      <title>Reporte General</title>
      <link rel="stylesheet" href="${window.location.origin}/formacion/PROYECTO/Formacion-Docente/assets/css/bootstrap.css">
      <style>
        body {
          font-family: Arial, sans-serif;
          padding: 30px;
          color: #333;
        }
        .encabezado-institucional {
          width: 100%;
          text-align: center;
          margin-bottom: 30px;
        }
        .img-header {
          width: 100%;
          max-height: 110px;
          object-fit: contain;
        }
        h2 {
          text-align: center;
          margin-bottom: 20px;
        }
        hr {
          border: 1px solid #ccc;
          margin: 20px 0;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
          border-radius: 5px;
          overflow: hidden;
        }
        th, td {
          border: 1px solid #ccc;
          padding: 8px;
          font-size: 13px;
          text-align: center;
          vertical-align: middle;
        }
        th {
          background-color: #343a40;
          color: white;
        }
        .footer {
          margin-top: 40px;
          font-size: 12px;
          text-align: right;
        }
        @media print {
          table, thead, tbody, th, td, tr {
            page-break-inside: avoid !important;
          }
        }
      </style>
    </head>
    <body>
      <div class="encabezado-institucional">
        <img src="${window.location.origin}/formacion/PROYECTO/Formacion-Docente/assets/img/header-institucional.png" alt="Encabezado Institucional" class="img-header">
      </div>
      <h2>Reporte General de Actividades Formativas</h2>
      <hr>
      ${filtrosAplicados}
      ${tabla}
      <div class="footer">
        Fecha de impresión: ${fechaImpresion}
      </div>
    </body>
    </html>
  `);
  ventana.document.close();
  ventana.focus();
  ventana.print();
}
