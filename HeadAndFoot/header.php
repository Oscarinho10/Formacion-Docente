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

    <!-- Estilos CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">

    <!-- Google Fonts (local) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/openSans.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/raleway.css">

    <!-- JS -->
    <script src="<?php echo BASE_URL; ?>/assets/js/scrollreveal.js"></script>
</head>
<body>
    <!-- CABECERA -->
    <div class="container-fluid pt-3 pb-3 titulo">
        <div class="row">
            <!-- Logo UAEM -->
            <div class="col-3 p-0 text-center align-self-center">
                <img src="<?php echo BASE_URL; ?>/assets/img/logo_blanco2.png" class="img-fluid"> 
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
                <img src="<?php echo BASE_URL; ?>/assets/img/uaem_logo2.png" class="img-fluid">
            </div>
        </div>
    </div>
