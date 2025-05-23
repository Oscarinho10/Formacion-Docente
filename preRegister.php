<?php
// Encabezado
include './HeadAndFoot/header.php';
?>



<!-- Formulario de pre-registro -->
<div style="width: 600px; margin: 40px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial;">
    <h3>Formulario de pre-resgistro</h3>
    <form method="post" action="procesar_formulario.php">
        <table style="width: 100%;">
            <tr>
                <td style="padding: 10px;">
                    <label>Nombre</label><br />
                    <input type="text" name="nombre" style="width: 95%;" />
                </td>
                <td style="padding: 10px;">
                    <label>Numero de control</label><br />
                    <input type="text" name="numero_control" style="width: 95%;" />
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;">
                    <label>Apellido Paterno</label><br />
                    <input type="text" name="apellido_paterno" style="width: 95%;" />
                </td>
                <td style="padding: 10px;">
                    <label>Apellido Materno</label><br />
                    <input type="text" name="apellido_materno" style="width: 95%;" />
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;">
                    <label>Perfil académico</label><br />
                    <select name="perfil_academico" style="width: 100%;">
                        <option value="">Selecciona perfil academico</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="docente">Docente</option>
                        <option value="egresado">Egresado</option>
                    </select>
                </td>
                <td style="padding: 10px;">
                    <label>Unidad académica</label><br />
                    <select name="unidad_academica" style="width: 100%;">
                        <option value="">Selecciona unidad academica</option>
                        <option value="ingenieria">Ingeniería</option>
                        <option value="ciencias">Ciencias</option>
                        <option value="letras">Letras</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right; padding: 10px;">
                    <button type="reset" style="background-color: #ccc; color: black; padding: 10px 20px; border: none;">Cancelar</button>
                    <button type="submit" style="background-color: #00aa00; color: white; padding: 10px 20px; border: none;">Enviar</button>
                </td>
            </tr>

            
        </table>
    </form>
</div>

<?php
// Pie de página
include './HeadAndFoot/footer.php';
?>
