const data = [
  { nombre: "Inteligencia artificial", fecha: "2025-06-10", tipo: "Acreditado" },
  { nombre: "Matemáticas", fecha: "2025-06-08", tipo: "Por asistir al curso" },
  { nombre: "Tralalero tralala", fecha: "2025-06-12", tipo: "Acreditado" },
  { nombre: "Diseño de algoritmos", fecha: "2025-05-30", tipo: "Por asistir al curso" },
  { nombre: "Taller de innovación", fecha: "2025-06-01", tipo: "Acreditado" },
  { nombre: "Educación inclusiva", fecha: "2025-06-05", tipo: "Acreditado" },
  { nombre: "Procesamiento de datos", fecha: "2025-06-03", tipo: "Por asistir al curso" },
  { nombre: "Comunicación efectiva", fecha: "2025-05-28", tipo: "Acreditado" }
];


  document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = data.map(item => `
      <tr>
        <td>${item.nombre}</td>
        <td>${item.fecha}</td>
        <td>${item.tipo}</td>
        <td class="text-center">
          <a href="seeConstancy.php" class="btn btn-sm btn-general">Ver constancias</a>
        </td>
      </tr>
    `).join('');
  });

