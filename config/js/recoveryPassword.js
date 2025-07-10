document.getElementById('formRecuperacion').addEventListener('submit', function (e) {
  e.preventDefault();
  const correo = document.getElementById('correoRecuperacion').value;

  Swal.fire({
    title: '¿Estás seguro?',
    text: `¿Deseas solicitar recuperación para: ${correo}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, enviar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('controller/solicitarRecuperacion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `correo=${encodeURIComponent(correo)}`
      })
      .then(res => res.text())
      .then(response => {
        if (response === 'ok') {
          Swal.fire('Enviado', 'Tu solicitud ha sido registrada correctamente.', 'success');
          document.getElementById('formRecuperacion').reset();
        } else {
          Swal.fire('Error', response, 'error');
        }
      })
      .catch(() => {
        Swal.fire('Error', 'No se pudo enviar la solicitud.', 'error');
      });
    }
  });
});
