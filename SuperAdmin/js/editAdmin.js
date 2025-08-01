document.addEventListener("DOMContentLoaded", function () {
  const id = document.body.getAttribute("data-id");
  const form = document.querySelector('form');

  // 1. Obtener datos del administrador
  fetch(`controller/getOneAdmin.php?id=${id}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        Swal.fire('Error', data.error, 'error');
        return;
      }

      document.getElementById("adminId").value = data.id_admin;
      document.getElementById("nombre").value = data.nombre;
      document.getElementById("apellido_paterno").value = data.apellido_paterno;
      document.getElementById("apellido_materno").value = data.apellido_materno;
      document.getElementById("numero_control").value = data.numero_control_rfc;
      document.getElementById("correo").value = data.correo_electronico;
    })
    .catch(error => {
      console.error("Error al cargar datos:", error);
      Swal.fire('Error', 'No se pudo cargar la información del administrador.', 'error');
    });

  // 2. Confirmación de envío con SweetAlert
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Detiene el envío normal

    Swal.fire({
      title: '¿Deseas guardar los cambios?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, guardar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#E74B3E",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Guardando...',
          html: 'Por favor espera unos segundos',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        setTimeout(() => {
          Swal.fire({
            title: '¡Cambios guardados!',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#28a745'
          }).then(() => {
            form.submit(); // Envío real
          });
        }, 2500);
      }
    });
  });
});
