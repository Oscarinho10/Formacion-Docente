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

    <!-- Bootstrap y estilos propios -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

    <!-- Sidebar personalizado -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/sidebar.css">

    <!-- Scroll Reveal -->
    <script src="<?php echo BASE_URL; ?>/assets/js/scrollreveal.js"></script>
</head>
<body>

<!-- CABECERA -->
<div class="container-fluid pt-3 pb-3 titulo">
    <!-- ... Tu encabezado actual ... -->
</div>

<!-- SIDEBAR -->
<div class="nav" id="nav">
    <nav class="nav__content">
        <div class="nav__toggle" id="nav-toggle">
            <i class='bx bx-chevron-right'></i>
        </div>

        <a href="#" class="nav__logo">
            <i class='bx bxs-heart'></i>
            <span class="nav__logo-name">Healthy</span>
        </a>

        <div class="nav__list">
            <a href="#" class="nav__link active-link">
                <i class='bx bx-grid-alt'></i>
                <span class="nav__name">Dashboard</span>
            </a>
            <a href="#" class="nav__link">
                <i class='bx bx-file'></i>
                <span class="nav__name">Appointments</span>
            </a>
            <a href="#" class="nav__link">
                <i class='bx bx-envelope'></i>
                <span class="nav__name">Messages</span>
            </a>
            <a href="#" class="nav__link">
                <i class='bx bx-bar-chart-square'></i>
                <span class="nav__name">Statistic</span>
            </a>
            <a href="#" class="nav__link">
                <i class='bx bx-cog'></i>
                <span class="nav__name">Settings</span>
            </a>
        </div>
    </nav>
</div>


<!-- jQuery, Popper y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.4/dist/umd/popper.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>

<!-- Sidebar JS -->
<script src="<?php echo BASE_URL; ?>/assets/js/sidebar.js"></script>

</body>
</html>
