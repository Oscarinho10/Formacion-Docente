 const data = [
    { nombre: "Juan Perez", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" },
    { nombre: "Oscar Maydon", fechas: ["Asistió", "No asistió", "No asistió", "No asistió"], constancia: "No" },
    { nombre: "Giovanni Pedraza", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "No" },
    { nombre: "Alejandro Morales", fechas: ["Asistió", "Asistió", "Asistió", "Asistió"], constancia: "Sí" }
  ];

  function renderTable(filter = "") {
    const body = document.getElementById('asistenciaBody');
    body.innerHTML = "";

    const filtered = data.filter(d => d.nombre.toLowerCase().includes(filter.toLowerCase()));

    filtered.forEach(item => {
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

  document.getElementById('searchInput').addEventListener('input', (e) => {
    renderTable(e.target.value);
  });

  document.addEventListener('DOMContentLoaded', () => {
    renderTable();
  });