document.addEventListener('DOMContentLoaded', cargarSolicitudes);

function cargarSolicitudes() {
  fetch('./controller/getSolicitudes.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('recoveryTableBody');
      tbody.innerHTML = '';

      if (!data || data.length === 0) {
        $('#recoveryTableBody').html(`
          <tr>
            <td colspan="5" class="text-center text-muted py-3">
              No hay solicitudes para reestablecer contraseña por el momento.
            </td>
          </tr>
        `);
        $('#pagination').html('');
        return;
      }

      data.forEach(usuario => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${usuario.nombre} ${usuario.apellido_paterno} ${usuario.apellido_materno}</td>
          <td>${usuario.correo_electronico}</td>
          <td>${usuario.fecha_solicitud || 'Desconocida'}</td>
          <td class="text-center">
            <button class="btn btn-success btn-sm" onclick="restablecer('${usuario.correo_electronico}')">
              <i class="fas fa-check"></i> Restablecer
            </button>
            <button class="btn btn-danger btn-sm" onclick="denegar('${usuario.correo_electronico}')">
              <i class="fas fa-times"></i> Denegar
            </button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch(() => {
      Swal.fire('Error', 'No se pudieron cargar las solicitudes.', 'error');
    });
}


function restablecer(correo) {
  fetch('../SuperAdmin/controller/recoveryPassword.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `correo=${correo}`
  }).then(res => res.text()).then(msg => {
    Swal.fire('Resultado', msg, 'info').then(() => location.reload());
  });
}

function denegar(correo) {
  fetch('../SuperAdmin/controller/dennyPassword.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `correo=${correo}`
  }).then(res => res.text()).then(msg => {
    Swal.fire('Resultado', msg, 'info').then(() => location.reload());
  });
}