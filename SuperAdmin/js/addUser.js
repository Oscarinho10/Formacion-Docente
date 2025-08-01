document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Detiene el envío

    Swal.fire({
      title: '¿Desea registrar este participante?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#E74B3E',
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

        // Recolecta los datos del formulario
        const formData = new FormData(form);

        // Envía los datos al backend con fetch
        fetch('controller/addUserController.php', {
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
                window.location.href = './requestSuper.php'; // Redirige o recarga
              });

            } else {
              // ⚠️ Mostrar el mensaje de error del backend
              Swal.fire({
                title: 'Error al registrar',
                text: data.error || 'Ha ocurrido un error inesperado.',
                icon: 'error',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#dc3545'
              });
            }
          })
          .catch(error => {
            Swal.close();
            Swal.fire({
              title: 'Error de red',
              text: 'No se pudo conectar con el servidor.',
              icon: 'error',
              confirmButtonText: 'Cerrar',
              confirmButtonColor: '#dc3545'
            });
          });
      }
    });
  });
});
