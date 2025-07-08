document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const form = document.getElementById("formParticipante");

    if (id && form) {
        form.action = "controller/editParticipantController.php";
        document.getElementById("id_usuario").value = id;
        document.querySelector("button[type='submit']").textContent = "Actualizar";

        fetch(`controller/editParticipantController.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                    return;
                }

                // Mapeos si vienen descripciones en lugar de valores exactos
                const perfilMap = {
                    "PROFESOR TIEMPO PARCIAL": "PTP",
                    "PROFESOR INVESTIGADOR DE TIEMPO PARCIAL": "PITP",
                    "PROFESOR TIEMPO COMPLETO": "PTC",
                    "PROFESOR INVESTIGADOR DE TIEMPO COMPLETO": "PITC",
                    "TECNICO ACADEMICO": "TA",
                    "TECNICO CULTURAL": "TC",
                    "ADMINISTRATIVO": "ADMIN"
                };

                const gradoMap = {
                    "Licenciatura": "Licenciatura",
                    "Maestria": "Maestria",
                    "Maestría": "Maestria",
                    "Doctorado": "Doctorado",
                    "Otro": "Otro"
                };

                // Rellenar campos
                document.getElementById("nombre").value = data.nombre;
                document.getElementById("apellido_paterno").value = data.apellido_paterno;
                document.getElementById("apellido_materno").value = data.apellido_materno;
                document.getElementById("sexo").value = data.sexo;
                document.getElementById("fecha_nacimiento").value = data.fecha_nacimiento;
                document.getElementById("numero_control").value = data.numero_control_rfc;
                document.getElementById("correo_electronico").value = data.correo_electronico;

                // Ajuste para selects con posibles diferencias de formato
                // Invertir el mapa para hacer lookup por descripción
                const perfilMapReverse = Object.entries(perfilMap).reduce((acc, [key, val]) => {
                    acc[key.toLowerCase()] = val;
                    return acc;
                }, {});

                const perfilValue = perfilMapReverse[data.perfil_academico.toLowerCase()] || data.perfil_academico;
                document.getElementById("perfil_academico").value = perfilValue;

                const gradoValue = gradoMap[data.grado_academico] || data.grado_academico;

                document.getElementById("perfil_academico").value = perfilValue;
                const unidadSelect = document.getElementById("unidad_academica");
                for (let i = 0; i < unidadSelect.options.length; i++) {
                    if (unidadSelect.options[i].text.trim().toLowerCase() === data.unidad_academica.trim().toLowerCase()) {
                        unidadSelect.selectedIndex = i;
                        break;
                    }
                }

                document.getElementById("grado_academico").value = gradoValue;

            })
            .catch(error => {
                console.error("Error al cargar participante:", error);
                Swal.fire('Error', 'No se pudo cargar el participante', 'error');
            });
    }
});
