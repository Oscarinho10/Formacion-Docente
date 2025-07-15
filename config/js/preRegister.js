document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "¿Deseas registrarte?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, registrar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#6c757d"
    }).then((result) => {
      if (result.isConfirmed) {
        // Mostrar loading
        Swal.fire({
          title: "Registrando...",
          html: "Por favor espera unos segundos",
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        const formData = new FormData(form);

        fetch("config/controller/preRegisterController.php", {
          method: "POST",
          body: formData
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire({
                title: "¡Registro exitoso!",
                text: data.message || "Registro realizado correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#28a745"
              });
              form.reset();
            } else {
              Swal.fire({
                title: "Error",
                text: data.error || "Ocurrió un error al registrar.",
                icon: "error",
                confirmButtonColor: "#d33"
              });
            }
          })
          .catch((err) => {
            console.error("Error en fetch:", err);
            Swal.fire({
              title: "Error",
              text: "Hubo un problema al enviar los datos.",
              icon: "error"
            });
          });
      }
    });
  });
});
