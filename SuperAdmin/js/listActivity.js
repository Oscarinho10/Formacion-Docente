const data = [
  { nombre: "Juan Perez", control: "45612", correo: "Juanperez@example.com" },
  { nombre: "Oscar Maydon", control: "5623", correo: "OscarMaydon@example.com" },
  { nombre: "Giovanni Pedraza", control: "568952", correo: "GiovanniPedraza@example.com" },
  { nombre: "Alejandro Morales", control: "89567", correo: "AlejandroMorales@example.com" },
  { nombre: "Diana Ruiz", control: "98712", correo: "DianaRuiz@example.com" },
  { nombre: "Ernesto Torres", control: "65234", correo: "ErnestoTorres@example.com" },
  { nombre: "Carla Romero", control: "47852", correo: "CarlaRomero@example.com" }
];

const rowsPerPage = 5;
let currentPage = 1;
let filtered = [...data];
let nombreActual = '';
let controlActual = '';
let picker = null;

function renderTable() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  filtered = data.filter(item => item.nombre.toLowerCase().includes(search));
  const totalPages = Math.ceil(filtered.length / rowsPerPage);
  const start = (currentPage - 1) * rowsPerPage;
  const end = Math.min(start + rowsPerPage, filtered.length);
  const visibleData = filtered.slice(start, end);

  document.getElementById('tableBody').innerHTML = visibleData.map(item => `
    <tr>
      <td>${item.nombre}</td>
      <td><strong>${item.control}</strong></td>
      <td>${item.correo}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-secondary" onclick="verMas('${item.nombre}', '${item.control}', '${item.correo}')"> <i class="fas fa-eye"></i> Ver más</button>
        <button class="btn btn-sm btn-success" onclick="abrirModal('${item.nombre}', '${item.control}')"><i class="fas fa-plus"></i> Asistencia</button>
      </td>
    </tr>
  `).join('');

  document.getElementById('paginationInfo').textContent =
    `Mostrando ${start + 1}-${end} de ${filtered.length} registros`;

  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  if (totalPages > 1) {
    pagination.innerHTML += `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage - 1})">&laquo;</a>
      </li>`;
    for (let i = 1; i <= totalPages; i++) {
      pagination.innerHTML += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
        </li>`;
    }
    pagination.innerHTML += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage + 1})">&raquo;</a>
      </li>`;
  }
}

function cambiarPagina(pag) {
  if (pag >= 1 && pag <= Math.ceil(filtered.length / rowsPerPage)) {
    currentPage = pag;
    renderTable();
  }
}

function abrirModal(nombre, control) {
  nombreActual = nombre;
  controlActual = control;

  fetch('modalSuper/calendarModal.php')
    .then(res => res.text())
    .then(html => {
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;
      document.body.appendChild(tempDiv);

      const modalElement = document.getElementById('calendarModal');
      const nombreSpan = document.getElementById('nombreParticipante');
      const fechaInput = document.getElementById('fechaAsistencia');
      const listaFechas = document.getElementById('listaFechasSeleccionadas');

      if (!modalElement || !nombreSpan || !fechaInput) {
        console.error("Error: elementos del modal no se encontraron.");
        return;
      }

      nombreSpan.textContent = `${nombre} (No. Control: ${control})`;

      if (picker) picker.destroy();

      picker = new Litepicker({
        element: fechaInput,
        format: 'YYYY-MM-DD',
        numberOfMonths: 2,
        numberOfColumns: 2,
        autoApply: true,
        mode: 'multiple'
      });

      picker.on('selected', () => {
        if (picker.selectedDates && picker.selectedDates.length > 0) {
          listaFechas.innerHTML = picker.selectedDates
            .map(f => new Date(f).toISOString().split('T')[0])
            .join(', ');
        } else {
          listaFechas.innerHTML = '<p>No se ha seleccionado ninguna fecha.</p>';
        }
      });

      document.getElementById('guardarAsistencia').addEventListener('click', () => {
        const fechas = picker.selectedDates;
        if (!fechas || fechas.length === 0) {
          alert("Debes seleccionar al menos una fecha.");
          return;
        }
        const fechasTexto = fechas.map(f => new Date(f).toISOString().split('T')[0]).join(', ');
        console.log("Participante:", nombreActual);
        console.log("Control:", controlActual);
        console.log("Fechas:", fechasTexto);
        alert("Fechas guardadas en consola.");
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
      });

      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    })
    .catch(err => {
      console.error("Error al cargar el modal:", err);
      alert("Error al cargar el modal.");
    });
}

function verMas(nombre, control, correo) {
  document.getElementById('infoNombre').textContent = nombre;
  document.getElementById('infoControl').textContent = control;
  document.getElementById('infoCorreo').textContent = correo;

  const modal = new bootstrap.Modal(document.getElementById('infoModal'));
  modal.show();
}


document.getElementById('searchInput').addEventListener('input', () => {
  currentPage = 1;
  renderTable();
});

document.addEventListener('DOMContentLoaded', renderTable);
