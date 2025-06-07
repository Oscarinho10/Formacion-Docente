<?php include_once(dirname(__FILE__) . '/../config/config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="index" />
    <meta name="keywords" content="formacion, formación, evaluacion, evaluación, docente, uaem" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Formación Docente</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/sideBar.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts (local) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/openSans.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/raleway.css" type="text/css">

    <!-- JS -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/scrollreveal.js"></script>
</head>

<body>


    <!-- SIDEBAR -->
    <div class="nav" id="nav">
        <nav class="nav__content">
            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-menu'></i>
            </div>


            <div class="nav__list">
                <a href="../SuperAdmin/initSuper.php" class="nav__link active-link"><span class="nav__name">Menú principal</span></a>
                <a href="../User/profilelUser.php" class="nav__link"><span class="nav__name">Perfil</span></a>
                <a href="../SuperAdmin/requestSuper.php" class="nav__link"><span class="nav__name">Solicitudes</span></a>
                <a href="../User/instructorCertificate.php" class="nav__link"><span class="nav__name">Instructores</span></a>
                <a href="../User/participantCertificate.php" class="nav__link"><span class="nav__name">Actividad formativa</span></a>
                <a href="../User/participantCertificate.php" class="nav__link"><span class="nav__name">Asistencias</span></a>
                <a href="../User/participantCertificate.php" class="nav__link"><span class="nav__name">Constancias</span></a>
                <a href="../User/participantCertificate.php" class="nav__link"><span class="nav__name">Reportes</span></a>
                <a href="../User/participantCertificate.php" class="nav__link"><span class="nav__name">Movimientos  n   </span></a>
                <div class="nav_bottom">
                    <a href="../login.php" class="nav__link">
                        <span class="nav__name">Cerrar sesión <i class='bx bx-log-out'></i></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- HEADER -->
    <div class="container-fluid pt-3 pb-3 titulo">
        <div class="row">
            <div class="col-3 p-0 text-center align-self-center">
                <img src="<?php echo BASE_URL; ?>/assets/img/SIGEM.png" class="logo2" alt="SIGEM-FD logo">

            </div>
            <div class="col-9 col-md-6 p-0 text-white text-center align-self-center d-none d-md-block">
                <h4 class="font-weight-bold">Universidad Autónoma del Estado de Morelos</h4>
                <h4>Departamento de Evaluación y Profesionalización de la Docencia</h4>
            </div>
            <div class="col-9 p-0 text-white text-center align-self-center d-md-none">
                <h5 class="font-weight-bold">Universidad Autónoma del Estado de Morelos</h5>
                <h6>Secretaría Académica</h6>
                <h6>Dirección General de Educación Superior</h6>
            </div>
            <div class="col-3 p-0 text-center align-self-center d-none d-md-block">
                <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" class="img-fluid" alt="UAEM logo">
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/sideBar.js"></script>

</body>

</html>