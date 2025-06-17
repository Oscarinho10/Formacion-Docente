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
    const rango = parseInt(document.getElementById("yearRange").value);
    const anioActual = new Date().getFullYear();
    const anioMin = anioActual - rango + 1;

    const filtrados = datos.filter(d =>
        d.anio >= anioMin &&
        (!search || d.unidad.toLowerCase().includes(search))
    );

    const tbody = document.getElementById("tbodyAnios");
    tbody.innerHTML = "";

    if (filtrados.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron resultados.</td></tr>`;
        return;
    }

    filtrados.forEach(row => {
        tbody.innerHTML += `
      <tr>
        <td>${row.anio}</td>
        <td>${row.unidad}</td>
        <td>${row.actividades}</td>
        <td>${row.participantes}</td>
        <td>${row.asistencias}</td>
      </tr>
    `;
    });
}

function imprimirTabla() {
    const tabla = document.getElementById("tablaAnios").outerHTML;

    const ventana = window.open('', '', 'width=1000,height=700');
    ventana.document.write(`
      <html>
        <head>
          <title>Reporte por unidad académica</title>
          <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
          <style>
            body {
              font-family: Arial, sans-serif;
              padding: 40px;
            }
            h2 {
              text-align: center;
              margin-bottom: 30px;
            }
            .logo {
              text-align: center;
              margin-bottom: 20px;
            }
            .logo img {
              height: 60px;
            }
            table {
              width: 100%;
              border-collapse: collapse;
              margin-top: 20px;
            }
            th, td {
              border: 1px solid #ccc;
              padding: 8px;
              font-size: 13px;
              text-align: center;
            }
            th {
              background-color: #f5f5f5;
            }
          </style>
        </head>
        <body>
          <div class="logo">
            <img src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt="Logo institucional">
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

// Inicializa con el rango actual
document.addEventListener("DOMContentLoaded", filtrarAnios);