document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');
  const submitBtn = document.querySelector('.btn-editar');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Detiene el envío

    Swal.fire({
      title: '¿Desea registrar este participante?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Registrando...',
          html: 'Por favor espera unos segundos',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        // Simulación de espera (2.5 segundos)
        setTimeout(() => {
          Swal.fire({
            title: '¡Registro exitoso!',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#28a745'
          }).then(() => {
            form.submit(); // Finalmente se envía el formulario real
          });
        }, 2500);
      }
    });
  });
});