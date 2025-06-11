 const actividades = [
      {
        nombre: "Curso de Liderazgo",
        horas: 20,
        estado: "Activo"
      },
      {
        nombre: "Seminario de Innovación",
        horas: 12,
        estado: "Inactivo"
      }
    ];

    function renderTabla() {
      const tbody = document.getElementById('activityTableBody');
      tbody.innerHTML = "";

      actividades.forEach((actividad, index) => {
        const checked = actividad.estado === "Activo" ? "checked" : "";

        const row = `
          <tr>
            <td>${actividad.nombre}</td>
            <td>${actividad.horas}</td>
            <td class="text-center">
              <label class="switch">
                <input type="checkbox" ${checked}>
                <span class="slider"></span>
              </label>
            </td>
            <td class="text-center">
              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas${index + 1}">Ver más</button>
              <a href="editTrainingActivity.php" class="btn btn-sm btn-general">Editar</a>
            </td>
          </tr>
        `;

        tbody.innerHTML += row;
      });
    }

    document.addEventListener('DOMContentLoaded', renderTabla);