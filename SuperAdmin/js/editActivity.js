document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  // ✅ Mostrar mensaje si se actualizó correctamente (?edit=ok)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("edit")) {
    Swal.fire({
      icon: "success",
      title: "Actividad actualizada correctamente",
      confirmButtonText: "Aceptar",
      confirmButtonColor: "#28a745"
    }).then(() => {
      const cleanUrl = window.location.origin + window.location.pathname;
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }

  // ✅ Confirmación al enviar el formulario
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Validación básica
    const campos = [
      "nombre",
      "descripcion",
      "lugar",
      "dirigido_a",
      "modalidad",
      "clasificacion",
      "tipo_evaluacion",
      "cupo",
      "total_horas",
      "fecha_inicio",
      "fecha_fin"
    ];

    let hayVacios = campos.some((id) => {
      const el = document.getElementById(id);
      return !el.value.trim();
    });

    if (hayVacios) {
      Swal.fire({
        icon: "warning",
        title: "Todos los campos obligatorios deben estar completos.",
        confirmButtonColor: "#dc3545"
      });
      return;
    }

    Swal.fire({
      title: "¿Desea actualizar esta actividad?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, actualizar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#6c757d"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Actualizando...",
          html: "Por favor espera un momento",
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
});
