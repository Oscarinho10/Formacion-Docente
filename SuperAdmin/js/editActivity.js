document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  // ✅ Mostrar mensaje si se actualizó correctamente (?edit=ok)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("edit") === "ok") {
    Swal.fire({
      icon: "success",
      title: "¡Actualización exitosa!",
      text: "La actividad fue actualizada correctamente.",
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

        const formData = new FormData(form);

        fetch("controller/editActivityController.php", {
          method: "POST",
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: "¡Actualización exitosa!",
                text: "La actividad fue actualizada correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#28a745"
              }).then(() => {
                const id = document.getElementById('id').value;
                window.location.href = `trainingActivity.php?id=${id}&edit=ok`;
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error al actualizar",
                text: data.error || "Ocurrió un problema inesperado.",
                confirmButtonColor: "#dc3545"
              });
            }
          })
          .catch((err) => {
            console.error("Error:", err);
            Swal.fire({
              icon: "error",
              title: "Error de red",
              text: "No se pudo conectar con el servidor.",
              confirmButtonColor: "#dc3545"
            });
          });
      }
    });
  });
});
