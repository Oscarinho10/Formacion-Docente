document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');
  const submitBtn = document.querySelector('.btn-editar');

  // Obtener ID del instructor desde la URL
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');

  if (!id) {
    Swal.fire("Error", "ID del instructor no proporcionado.", "error");
    return;
  }

  // Precargar datos del instructor
  fetch(`controller/editInstructorController.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        Swal.fire("Error", data.error, "error");
        return;
      }

      document.getElementById('id_usuario').value = data.id_usuario;
      document.getElementById('nombre').value = data.nombre;
      document.getElementById('apellido_paterno').value = data.apellido_paterno;
      document.getElementById('apellido_materno').value = data.apellido_materno;
      document.getElementById('sexo').value = data.sexo;
      document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento;
      document.getElementById('numero_control').value = data.numero_control_rfc;
      document.getElementById('correo').value = data.correo_electronico;
      document.getElementById('perfil_academico').value = data.perfil_academico;
      document.getElementById('unidad_academica').value = data.unidad_academica;
      document.getElementById('grado_academico').value = data.grado_academico;
    })
    .catch(err => {
      console.error("Error al cargar instructor:", err);
      Swal.fire("Error", "No se pudieron cargar los datos del instructor.", "error");
    });

  // Evento de edición con confirmación
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
      title: '¿Desea guardar los cambios del instructor?',
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
          html: 'Por favor espera unos segundos',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        setTimeout(() => {
          form.submit(); // Enviar formulario al backend
        }, 2000);
      }
    });
  });
});
