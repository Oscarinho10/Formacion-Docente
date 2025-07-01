document.addEventListener("DOMContentLoaded", function () {
  $('#instructores').select2({
    placeholder: 'Buscar instructores',
    allowClear: true
  });

  const form = document.querySelector('form');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const instructoresSeleccionados = $('#instructores').val();
    if (!instructoresSeleccionados || instructoresSeleccionados.length === 0) {
      Swal.fire({
        title: 'Debe seleccionar al menos un instructor.',
        icon: 'warning',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#dc3545'
      });
      return;
    }

    Swal.fire({
      title: '¿Desea registrar esta actividad?',
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

        setTimeout(() => {
          Swal.fire({
            title: '¡Registro exitoso!',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#28a745'
          }).then(() => {
            form.submit();
          });
        }, 2000);
      }
    });
  });
});
