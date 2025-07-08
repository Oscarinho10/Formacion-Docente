
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const form = document.getElementById("formParticipante");

    if (id) {
        
        form.action = "controller/editParticipantController.php";
        document.getElementById("id_usuario").value = id;
        document.querySelector("button[type='submit']").textContent = "Actualizar";

        // Obtener datos del participante
        fetch(`controller/editParticipantController.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                    return;
                }

                // Rellenar campos
                document.getElementById("nombre").value = data.nombre;
                document.getElementById("apellido_paterno").value = data.apellido_paterno;
                document.getElementById("apellido_materno").value = data.apellido_materno;
                document.getElementById("sexo").value = data.sexo;
                document.getElementById("fecha_nacimiento").value = data.fecha_nacimiento;
                document.getElementById("numero_control").value = data.numero_control_rfc;
                document.getElementById("correo_electronico").value = data.correo_electronico;
                document.getElementById("perfil_academico").value = data.perfil_academico;
                document.getElementById("unidad_academica").value = data.unidad_academica;
                document.getElementById("grado_academico").value = data.grado_academico;
            })
            .catch(error => {
                console.error("Error al cargar participante:", error);
                Swal.fire('Error', 'No se pudo cargar el participante', 'error');
            });
    }
});

