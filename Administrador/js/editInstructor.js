document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');

  if (!id) {
    Swal.fire("Error", "ID del instructor no proporcionado.", "error");
    return;
  }

  // ✅ Mostrar SweetAlert si la edición fue exitosa
  if (urlParams.get('editado') === 'ok') {
    Swal.fire({
      title: '¡Actualización exitosa!',
      icon: 'success',
      confirmButtonText: 'Aceptar',
      confirmButtonColor: '#28a745'
    }).then(() => {
      // Limpiar la URL sin recargar
      const cleanUrl = window.location.origin + window.location.pathname + '?id=' + id;
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }

  // Función para hacer coincidencia flexible
  function normalizar(texto) {
    return texto
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .trim()
      .toLowerCase();
  }

  function seleccionarOptionPorTextoNormalizado(selectElement, valorBD) {
    const normalizadoBD = normalizar(valorBD);
    const opciones = selectElement.options;
    for (let i = 0; i < opciones.length; i++) {
      const valor = normalizar(opciones[i].value);
      if (valor === normalizadoBD) {
        selectElement.selectedIndex = i;
        return;
      }
    }
    console.warn(`❗ No se encontró coincidencia exacta para: ${valorBD}`);
  }

  // Cargar datos del instructor
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
      document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento;
      document.getElementById('numero_control_rfc').value = data.numero_control_rfc;
      document.getElementById('correo_electronico').value = data.correo_electronico;

      seleccionarOptionPorTextoNormalizado(
        document.getElementById('sexo'),
        data.sexo
      );
      seleccionarOptionPorTextoNormalizado(
        document.getElementById('perfil_academico'),
        data.perfil_academico
      );
      seleccionarOptionPorTextoNormalizado(
        document.getElementById('unidad_academica'),
        data.unidad_academica
      );
      seleccionarOptionPorTextoNormalizado(
        document.getElementById('grado_academico'),
        data.grado_academico
      );
    })
    .catch(err => {
      console.error("Error al cargar instructor:", err);
      Swal.fire("Error", "No se pudieron cargar los datos del instructor.", "error");
    });

  // Confirmación al editar con fetch
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

        const formData = new FormData(form);

        fetch('controller/editInstructorController.php', {
          method: 'POST',
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: '¡Actualización exitosa!',
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#28a745'
              }).then(() => {
                window.location.href = `listInstructors.php?id=${id}&editado=ok`;
              });
            } else {
              Swal.fire("Error", data.error || "No se pudo guardar.", "error");
            }
          })
          .catch(err => {
            console.error("Error al enviar datos:", err);
            Swal.fire("Error", "Ocurrió un problema al guardar los datos.", "error");
          });
      }
    });
  });
});
