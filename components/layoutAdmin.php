<?php include_once(dirname(__FILE__) . '/../config/config.php'); ?>

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">

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
                <a href="../Administrador/initAdmin.php" class="nav__link <?php echo ($currentPage == 'initAdmin.php') ? 'active-link' : ''; ?>"><span class="nav__name">Menú principal</span></a>
                <a href="../Administrador/profileUser.php" class="nav__link <?php echo ($currentPage == 'profilelUser.php') ? 'active-link' : ''; ?>"><span class="nav__name">Perfil</span></a>
                <a href="../Administrador/listParticipants.php" class="nav__link <?php echo ($currentPage == 'listParticipants.php') ? 'active-link' : ''; ?>"><span class="nav__name">Solicitudes</span></a>
                <a href="../Administrador/listInstructors.php" class="nav__link <?php echo ($currentPage == 'listInstructors.php') ? 'active-link' : ''; ?>"><span class="nav__name">Instructores</span></a>
                <a href="../Administrador/listActivitys.php" class="nav__link <?php echo ($currentPage == 'listActivitys.php') ? 'active-link' : ''; ?>"><span class="nav__name">Actividad Formativa</span></a>
                <a href="../Administrador/checkList.php" class="nav__link <?php echo ($currentPage == 'checkList.php') ? 'active-link' : ''; ?>"><span class="nav__name">Asistencias</span></a>
                <div class="nav_bottom">
                    <a href="../logout.php" class="nav__link">
                        <span class="nav__name">Cerrar sesión <i class='bx bx-log-out'></i></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- HEADER -->
    <div class="container-fluid py-2 titulo">
        <div class="row align-items-center">

            <!-- Logo UAEM - solo en md en adelante -->
            <div class="col-3 text-center d-none d-md-block">
                <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" class="img-fluid" alt="UAEM logo" style="max-height: 130px;">
            </div>

            <!-- Texto en md y arriba -->
            <div class="col-md-6 text-center text-white d-none d-md-block">
                <h5 class="mb-1 font-weight-bold">Universidad Autónoma del Estado de Morelos</h5>
                <h6 class="mb-0">Departamento de Evaluación y Profesionalización de la Docencia</h6>
            </div>

            <!-- Texto reducido en celulares -->
            <div class="col-9 text-center text-white d-md-none">
                <h6 class="mb-0 font-weight-bold">UAEM</h6>
                <small>DEPD - Secretaría Académica</small>
            </div>

            <!-- Logo SIGEM, siempre visible -->
            <div class="col-3 text-center d-none d-md-block">
                <img src="<?php echo BASE_URL; ?>/assets/img/SIGEM.png" class="img-fluid" alt="SIGEM logo" style="max-height: 130px;">
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