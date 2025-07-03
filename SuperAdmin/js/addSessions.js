document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');

  // Mostrar mensaje si la URL contiene ?ok
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has('ok')) {
    Swal.fire({
      icon: 'success',
      title: 'Sesión guardada correctamente',
      confirmButtonText: 'Aceptar',
      confirmButtonColor: '#28a745'
    }).then(() => {
      const cleanUrl = window.location.origin + window.location.pathname + window.location.search.replace(/[\?&]ok\b/, '');
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }

  if (urlParams.has('deleted')) {
    Swal.fire({
      icon: 'success',
      title: 'Sesión eliminada correctamente',
      confirmButtonText: 'Aceptar',
      confirmButtonColor: '#28a745'
    }).then(() => {
      const cleanUrl = window.location.origin + window.location.pathname + window.location.search.replace(/[\?&]deleted\b/, '');
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }

  // Confirmación al guardar
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const fecha = document.getElementById('fecha').value;
    const horaInicio = document.getElementById('hora_inicio').value;
    const horaFin = document.getElementById('hora_fin').value;
    const instructor = document.getElementById('id_usuario').value;

    if (!fecha || !horaInicio || !horaFin || !instructor) {
      Swal.fire({
        icon: 'warning',
        title: 'Todos los campos son obligatorios.',
        confirmButtonColor: '#dc3545'
      });
      return;
    }

    Swal.fire({
      title: '¿Desea guardar esta sesión?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, guardar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Guardando...',
          html: 'Por favor espera un momento',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        setTimeout(() => {
          form.submit();
        }, 800);
      }
    });
  });

  // Confirmación al eliminar una sesión
  document.querySelectorAll('.form-eliminar-sesion').forEach(formEliminar => {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta sesión se eliminará permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Eliminando...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
          });

          // Crear y enviar un formulario oculto con los mismos datos
          const tempForm = document.createElement('form');
          tempForm.method = formEliminar.method;
          tempForm.action = formEliminar.action;

          for (const el of formEliminar.elements) {
            if (el.name) {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = el.name;
              input.value = el.value;
              tempForm.appendChild(input);
            }
          }

          document.body.appendChild(tempForm);
          tempForm.submit();
        }
      });
    });
  });
});
