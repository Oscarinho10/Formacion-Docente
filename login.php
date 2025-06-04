<?php
session_start();
include('./config/conexion.php');

if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consulta el usuario en base al correo
    $query = "SELECT * FROM administradores WHERE correo = '$correo'";
    $resultado = pg_query($conn, $query);

    if ($resultado && pg_num_rows($resultado) == 1) {
        $usuario = pg_fetch_assoc($resultado);


        // Si es que las contraseñas están encriptadas, se puede usar la función crypt() para comparar
        // if (crypt($contrasena, $usuario['contrasena']) == $usuario['contrasena']) {

        // Comparar contraseña en texto plano (sin encriptar)
        if ($contrasena == $usuario['contrasena']) {

            // Guardar datos del usuario en sesión
            $_SESSION['usuario'] = $usuario;

            // Redirigir según el rol
            switch ($usuario['rol']) {
                case 'superAdmin':
                    header("Location: SuperAdmin/initSuper.php");
                    break;
                case 'administrador':
                    header("Location: Administrador/initAdmin.php");
                    break;
                case 'usuario':
                    header("Location: User/initUser.php");
                    break;
                default:
                    header("Location: inicio.php");
            }
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Correo no registrado');</script>";
    }
}
?>

<?php include('HeadAndFoot/header.php'); ?>

<!-- LOGIN -->
<div class="login-container">
    <!-- Columna del formulario -->
    <div class="login-form">
        <form method="POST" action="">
            <h5 class="mt-3 mb-2">Correo electrónico*</h5>
            <input type="email" name="correo" class="form-control" placeholder="Ingresa tu correo" required>

            <h5 class="mt-3 mb-2">Contraseña*</h5>
            <input type="password" name="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>

            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>

        <button onclick="window.location.href='<?php echo BASE_URL; ?>/preRegister.php'" class="btn btn-success w-100">Registrarse</button>
        <a href="#" class="small-link">¿Olvidaste tu contraseña?</a>
    </div>

    <!-- Columna de información -->
    <div class="login-info">
        <div class="text-container">
            <h4>Sistema de formación docente</h4>
            <p>Capacitación para renovar la práctica docente, impulsar la innovación educativa y favorecer el desarrollo integral del estudiantado.</p>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" alt="icono uaem" class="img-fluid">
    </div>
</div>

<?php include('HeadAndFoot/footer.php'); ?>
