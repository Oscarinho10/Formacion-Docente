 document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');
  const submitBtn = document.querySelector('.btn-registrar');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Detiene el envío tradicional

    Swal.fire({
      title: '¿Desea registrar este instructor?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d'
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData(form);

        Swal.fire({
          title: 'Registrando...',
          html: 'Por favor espera unos segundos',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        fetch('controller/addInstructorController.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          Swal.close();
          if (data.success) {
            Swal.fire({
              title: '¡Registro exitoso!',
              icon: 'success',
              confirmButtonText: 'Aceptar',
              confirmButtonColor: '#28a745'
            }).then(() => {
              // Redirige a tabla de instructores
              window.location.href = 'instructorSuper.php';
            });
          } else {
            Swal.fire({
              title: 'Error',
              text: data.error || 'No se pudo registrar.',
              icon: 'error'
            });
          }
        })
        .catch(() => {
          Swal.close();
          Swal.fire('Error', 'Ocurrió un error inesperado.', 'error');
        });
      }
    });
  });
});
