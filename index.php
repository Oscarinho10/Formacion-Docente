<?php
// index.php
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="index" />
    <meta name="keywords" content="formacion, formación, evaluacion, evaluación, docente, uaem" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Formación Docente</title>

    <!-- Estilos css-->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/estilo.css">

    <!-- Estilos FontAwesome -->
    <link rel="stylesheet" href="./fontawesome/brands.min.css">
    <link rel="stylesheet" href="./fontawesome/solid.min.css">
    <link rel="stylesheet" href="./fontawesome/all.min.css">

    <!-- Estilos Google Fonts -->
    <link rel="stylesheet" href="./fonts/openSans.css">
    <link rel="stylesheet" href="./fonts/raleway.css">

    <script src="./js/scrollreveal.js"></script>

</head>

<body>

    <!-- CABECERA -->
    <div class="container-fluid pt-3 pb-3 titulo">
        <div class="row">
            <!-- Logo UAEM -->
            <div class="col-3 p-0 text-center align-self-center">
                <img src="./img/logo_blanco2.png" class="img-fluid">
            </div>

            <!-- Título versión escritorio -->
            <div class="col-9 col-md-6 p-0 text-white text-center align-self-center d-none d-md-block">
                <h4 class="font-weight-bold">Universidad Autónoma del Estado de Morelos</h4>
                <h4>Secretaría Académica</h4>
                <h4>Dirección General de Educación Superior</h4>
                <h4>Departamento de Evaluación y Profesionalización de la Docencia</h4>
            </div>

            <!-- Título versión móvil -->
            <div class="col-9 p-0 text-white text-center align-self-center d-md-none">
                <h5 class="font-weight-bold">Universidad Autónoma del Estado de Morelos</h5>
                <h6>Secretaría Académica</h6>
                <h6>Dirección General de Educación Superior</h6>
            </div>

            <!-- Logo 'Por una humanidad culta' -->
            <div class="col-3 p-0 text-center align-self-center d-none d-md-block">
                <img src="./img/uaem_logo2.png" class="img-fluid">
            </div>
        </div>
    </div>

    <!-- LOGIN -->
    <div class="login-container">
        <!-- Columna del formulario -->
        <div class="login-form">
            <h5 class="mb-4">Correo electrónico*</h5>
            <input type="email" class="form-control" placeholder="Ingresa tu correo">

            <h5 class="mt-3 mb-2">Contraseña*</h5>
            <input type="password" class="form-control" placeholder="Ingresa tu contraseña">

            <button class="btn btn-primary w-100">Iniciar sesión</button>
            <a href="#" class="small-link">¿Olvidaste tu contraseña?</a>

            <button class="btn btn-success w-100">Registrarse</button>
        </div>

        <!-- Columna de información -->
        <div class="login-info">
            <div class="text-container">
                <h4>Sistema de formación docente</h4>
                <p>Capacitación para renovar la práctica docente, impulsar la innovación educativa y favorecer el desarrollo integral del estudiantado.</p>
            </div>
            <img src="./img/logo_blanco2.png" alt="icono uaem" class="img-fluid">
        </div>

    </div>

    <!-- FOOTER -->
    <div id="miFooter" class="container-fluid">
        <div class="row h-100">
            <!-- Fondo version escritorio MD -->
            <svg width='100%' height='150' viewBox="0 0 100 100" preserveAspectRatio="none" class="fondo-footer-escritorio d-none d-md-block d-lg-none">
                <polygon points="0,0 0,100 44,100 29,0" class="fondo-figura" />
            </svg>
            <!-- Fondo version escritorio LG, XL -->
            <svg width='100%' height='150' viewBox="0 0 100 100" preserveAspectRatio="none" class="fondo-footer-escritorio d-none d-lg-block">
                <polygon points="0,0 0,100 40,100 25,0" class="fondo-figura" />
            </svg>
            <div class="col-md-4 col-lg-3 align-self-center d-none d-md-block">
                <div class="text-center h-100">
                    <h6 class="text-white">&iexcl;Síguenos en nuestras redes sociales!</h6>
                    <div class="flex-center">
                        <!-- Correo evaluacion docente -->
                        <a href="mailto:eval_docente@uaem.mx" class="icon-button rs-correo"><i class="fas fa-envelope"></i><span></span></a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/uaemformaciondocente" class="icon-button rs-facebook" target="_blank"><i class="fab fa-facebook-f"></i><span></span></a>
                        <!-- Canal Youtube evaluacion docente -->
                        <a href="https://www.youtube.com/channel/UCvc3SSAArfY-DsWXXZ4mwhg" class="icon-button rs-youtube" target="_blank"><i class="fab fa-youtube"></i><span></span></a>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-lg-2 align-self-center d-none d-md-block"></div>
            <div class="col-md-7 col-lg-7 align-self-center text-white d-none d-md-block">
                <h5 class="d-none d-md-block">Departamento de Evaluación y Profesionalización de la Docencia</h5>
                <h6 class="d-block d-md-none font-weight-bold">Departamento de Evaluación y Profesionalización de la Docencia</h6>
                <h6><i class="fas fa-map-marker-alt"></i> Av. Universidad 1001 Col. Chamilpa C.P. 62209, Cuernavaca, Morelos</h6>
                <h6><i class="fas fa-phone"></i> (777) 329 70 00 Ext. 3352 y 3935</h6>
                <!-- Correo evaluacion docente -->
                <h6><i class="far fa-envelope"></i> eval_docente@uaem.mx, formacion.docente.ns@uaem.mx</h6>

            </div>
            <!-- Fondo version movil -->
            <div class="col-12 align-self-center d-md-none fondo-footer-movil text-white pt-3 pb-3">
                <h6 class="font-weight-bold">Departamento de Evaluación y Profesionalización de la Docencia</h6>
                <h6><i class="fas fa-map-marker-alt"></i> Av. Universidad 1001 Col. Chamilpa C.P. 62209, Cuernavaca, Morelos</h6>
                <h6><i class="fas fa-phone"></i> (777) 329 70 00 Ext. 3352 y 3935</h6>
                <!-- Correo evaluacion docente -->
                <h6><i class="far fa-envelope"></i> eval_docente@uaem.mx, formacion.docente.ns@uaem.mx</h6>
            </div>
            <div class="col-12 align-self-center text-center d-md-none fondo-footer-movil2 text-white pt-3 pb-3">
                <h6 class="text-white">&iexcl;Síguenos en nuestras redes sociales!</h6>
                <div class="flex-center">
                    <!-- Correo evaluacion docente -->
                    <a href="mailto:eval_docente@uaem.mx" class="icon-button rs-correo"><i class="fas fa-envelope"></i><span></span></a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/uaemformaciondocente" class="icon-button rs-facebook" target="_blank"><i class="fab fa-facebook-f"></i><span></span></a>
                    <!-- Canal Youtube evaluacion docente -->
                    <a href="https://www.youtube.com/channel/UCvc3SSAArfY-DsWXXZ4mwhg" class="icon-button rs-youtube" target="_blank"><i class="fab fa-youtube"></i><span></span></a>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/jquery-3.6.0.slim.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script>
        window.sr = ScrollReveal();
        sr.reveal('.carousel', {
            duration: 3000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.text-justify', {
            duration: 2000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('#titulo', {
            duration: 2000,
            origin: 'rigth',
            distance: '20px'
        });
    </script>


</body>

</html>