function restablecer(correo) {
  fetch('controller/restablecerContrasena.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `correo=${correo}`
  }).then(res => res.text()).then(msg => {
    Swal.fire('Resultado', msg, 'info').then(() => location.reload());
  });
}

function denegar(correo) {
  fetch('controller/denegarRecuperacion.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `correo=${correo}`
  }).then(res => res.text()).then(msg => {
    Swal.fire('Resultado', msg, 'info').then(() => location.reload());
  });
}