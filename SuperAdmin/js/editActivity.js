document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  if (!id) {
    Swal.fire("Error", "ID de la actividad no proporcionado.", "error");
    return;
  }

  if (urlParams.get("editado") === "ok") {
    Swal.fire({
      title: "¡Actualización exitosa!",
      icon: "success",
      confirmButtonText: "Aceptar",
      confirmButtonColor: "#28a745"
    }).then(() => {
      const cleanUrl = window.location.origin + window.location.pathname + "?id=" + id;
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }

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

  // Cargar datos de la actividad
  fetch(`controller/editActivityController.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        Swal.fire("Error", data.error, "error");
        return;
      }

      document.getElementById("id_actividad").value = data.id_actividad;
      document.getElementById("nombre").value = data.nombre;
      document.getElementById("descripcion").value = data.descripcion;
      document.getElementById("lugar").value = data.lugar;
      document.getElementById("dirigido_a").value = data.dirigido_a;
      document.getElementById("cupo").value = data.cupo;
      document.getElementById("total_horas").value = data.total_horas;
      document.getElementById("fecha_inicio").value = data.fecha_inicio;
      document.getElementById("fecha_fin").value = data.fecha_fin;

      seleccionarOptionPorTextoNormalizado(
        document.getElementById("tipo_evaluacion"),
        data.tipo_evaluacion
      );
      seleccionarOptionPorTextoNormalizado(
        document.getElementById("modalidad"),
        data.modalidad
      );
      seleccionarOptionPorTextoNormalizado(
        document.getElementById("clasificacion"),
        data.clasificacion
      );
    })
    .catch(err => {
      console.error("Error al cargar actividad:", err);
      Swal.fire("Error", "No se pudieron cargar los datos de la actividad.", "error");
    });

  // Confirmación al editar con fetch
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "¿Desea guardar los cambios de la actividad?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, guardar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#6c757d"
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Guardando...",
          html: "Por favor espera unos segundos",
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
                icon: "success",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#28a745"
              }).then(() => {
                window.location.href = `trainingActivity.php?id=${id}&editado=ok`;
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
