<?php
include('config/conexion.php');
include('config/controller/detailsActivityController.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($actividad['nombre']); ?></title>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body>

    <?php include('HeadAndFoot/header.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Actividad formativa</h2>
    </div>

    <div class="container py-5">
        <?php if ($actividad): ?>
            <div class="card p-4">
                <div class="row">
                    <!-- Imagen -->
                    <div class="col-md-5 text-center mb-3 mb-md-0">
                        <img src="<?php echo htmlspecialchars($actividad['url_imagen']); ?>" alt="Imagen de actividad" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Contenido textual -->
                    <div class="col-md-7">
                        <h2 class="fw-bold"><?php echo htmlspecialchars($actividad['nombre']); ?></h2>

                        <div class="mt-4">
                            <h5><i class="fas fa-clipboard-list text-primary me-2"></i>Curso:</h5>
                            <p><?php echo nl2br(htmlspecialchars($actividad['nombre'])); ?></p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-map-marker-alt me-2 text-primary"></i>Modalidad:</h5>
                            <p><?php echo nl2br(htmlspecialchars($actividad['modalidad'])); ?></p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-bullseye me-2 text-primary"></i>Propósito</h5>
                            <p><?php echo nl2br(htmlspecialchars($actividad['descripcion'])); ?></p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-users me-2 text-primary"></i>Dirigido a</h5>
                            <p><?php echo htmlspecialchars($actividad['dirigido_a']); ?></p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Lugar</h5>
                            <p><?php echo htmlspecialchars($actividad['lugar']); ?></p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-clock me-2 text-primary"></i>Duración</h5>
                            <p><?php echo htmlspecialchars($actividad['total_horas']); ?> horas</p>
                        </div>

                        <div class="mt-3">
                            <h5><i class="fas fa-clock me-2 text-primary"></i>Horarios y ponentes</h5>
                            <p><?php echo htmlspecialchars($actividad['descripcion_horarios']); ?></p>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="login.php" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Inscribirme
                            </a>
                            <a href="catalogo.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Regresar
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No se encontró la actividad solicitada.
            </div>
        <?php endif; ?>
    </div>

    <?php include('HeadAndFoot/footer.php'); ?>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/config/js/detailActivity.js"></script>
</body>
</html>
