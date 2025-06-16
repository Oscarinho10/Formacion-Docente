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

// Inicializar con todos los datos
document.addEventListener("DOMContentLoaded", () => renderTabla(data));


function imprimirReporte() {
  const tabla = document.getElementById("tablaReporte").outerHTML;

  const ventana = window.open('', '', 'height=700,width=1000');
  ventana.document.write(`
    <html>
    <head>
      <title>Reporte General</title>
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
      <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .logo-container { text-align: center; margin-bottom: 20px; }
        .logo-container img { height: 60px; margin: 0 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 13px; }
        th { background-color: #f0f0f0; }
      </style>
    </head>
    <body>
      <div class="logo-container">
        <img src="<?php echo BASE_URL; ?>/assets/img/uaem.png" alt="UAEM">
        <img src="<?php echo BASE_URL; ?>/assets/img/sigem.png" alt="SIGEM">
      </div>
      <h2>Reporte General de Actividades Formativas</h2>
      ${tabla}
    </body>
    </html>
  `);
  ventana.document.close();
  ventana.focus();
  ventana.print();
  // ventana.close(); // opcional
}