document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
      title: '¿Desea registrar esta actividad?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#E74B3E",
      reverseButtons: true
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

        setTimeout(() => {
          form.submit(); // Envío real del formulario
        }, 1000);
      }
    });
  });
});
