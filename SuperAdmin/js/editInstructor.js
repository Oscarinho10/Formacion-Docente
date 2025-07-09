document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form');

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');

  if (!id) {
    Swal.fire("Error", "ID del instructor no proporcionado.", "error");
    return;
  }

  // Función para hacer coincidencia flexible (insensible a mayúsculas, espacios, acentos)
  function normalizar(texto) {
    return texto
      .normalize("NFD") // elimina acentos
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
      console.log("Datos cargados:", data);

      if (data.error) {
        Swal.fire("Error", data.error, "error");
        return;
      }

      // Carga simple
      document.getElementById('id_usuario').value = data.id_usuario;
      document.getElementById('nombre').value = data.nombre;
      document.getElementById('apellido_paterno').value = data.apellido_paterno;
      document.getElementById('apellido_materno').value = data.apellido_materno;
      document.getElementById('sexo').value = data.sexo;
      document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento;
      document.getElementById('numero_control').value = data.numero_control_rfc;
      document.getElementById('correo').value = data.correo_electronico;

      // Selección flexible para los select
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

  // Confirmación al editar
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
        }, 1500);
      }
    });
  });
});
