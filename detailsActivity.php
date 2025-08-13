<?php
include('config/conexion.php');
include('config/controller/detailsActivityController.php'); // Debe llenar $actividad

/**
 * Helpers (mismos que en catálogo)
 */
if (!function_exists('url_for')) {
  function url_for($path) {
    return RUTA_BASE . '/' . ltrim($path, '/');
  }
}
if (!function_exists('resolve_image_src')) {
  function resolve_image_src($img) {
    if (!isset($img) || trim($img) === '') {
      return url_for('assets/img/placeholder.png');
    }
    $img = trim($img);

    if (preg_match('~^https?://~i', $img)) {
      return $img;
    }
    if (isset($img[0]) && $img[0] === '/') {
      if (strpos($img, RUTA_BASE . '/') === 0) return $img;
      return url_for(ltrim($img, '/'));
    }
    if (stripos($img, 'uploads/imagenes/') === 0) {
      return url_for($img);
    }
    return url_for('uploads/imagenes/' . $img);
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($actividad['nombre']) ? htmlspecialchars($actividad['nombre'], ENT_QUOTES, 'UTF-8') : 'Actividad'; ?></title>

  <link rel="stylesheet" href="<?php echo htmlspecialchars(url_for('assets/css/bootstrap.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(url_for('assets/css/estilo.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(url_for('assets/fontawesome/all.min.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(url_for('assets/fontawesome/brands.min.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(url_for('assets/fontawesome/solid.min.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>
<body>

<?php include('HeadAndFoot/header.php'); ?>

<div class="container mt-4">
  <h2 class="text-center">Actividad formativa</h2>
</div>

<div class="container py-5">
  <?php if (!empty($actividad)): ?>
    <div class="card p-4">
      <div class="row">
        <!-- Imagen -->
        <div class="col-md-5 text-center mb-3 mb-md-0">
          <?php
            $img = isset($actividad['url_imagen']) ? $actividad['url_imagen'] : '';
            $src = resolve_image_src($img);
          ?>
          <img
            src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
            alt="Imagen de actividad"
            class="img-fluid rounded"
            style="max-height: 300px; object-fit: cover;"
            onerror="this.onerror=null;this.src='<?php echo htmlspecialchars(url_for('assets/img/placeholder.png'), ENT_QUOTES, 'UTF-8'); ?>';"
          >
        </div>

        <!-- Contenido textual -->
        <div class="col-md-7">
          <h2 class="fw-bold"><?php echo htmlspecialchars($actividad['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>

          <div class="mt-4">
            <h5><i class="fas fa-clipboard-list text-primary me-2"></i>Curso:</h5>
            <p><?php echo nl2br(htmlspecialchars($actividad['nombre'], ENT_QUOTES, 'UTF-8')); ?></p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-map-marker-alt me-2 text-primary"></i>Modalidad:</h5>
            <p><?php echo nl2br(htmlspecialchars($actividad['modalidad'], ENT_QUOTES, 'UTF-8')); ?></p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-bullseye me-2 text-primary"></i>Propósito</h5>
            <p><?php echo nl2br(htmlspecialchars($actividad['descripcion'], ENT_QUOTES, 'UTF-8')); ?></p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-users me-2 text-primary"></i>Dirigido a</h5>
            <p><?php echo htmlspecialchars($actividad['dirigido_a'], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Lugar</h5>
            <p><?php echo htmlspecialchars($actividad['lugar'], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-clock me-2 text-primary"></i>Duración</h5>
            <p><?php echo htmlspecialchars($actividad['total_horas'], ENT_QUOTES, 'UTF-8'); ?> horas</p>
          </div>

          <div class="mt-3">
            <h5><i class="fas fa-clock me-2 text-primary"></i>Horarios y ponentes</h5>
            <p><?php echo htmlspecialchars($actividad['descripcion_horarios'], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>

          <!-- Botones -->
          <div class="mt-4 d-flex justify-content-between">
            <a href="<?php echo htmlspecialchars(url_for('login.php'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">
              <i class="fas fa-sign-in-alt me-2"></i>Inscribirme
            </a>
            <a href="<?php echo htmlspecialchars(url_for('catalogo.php'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary">
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
<script src="<?php echo htmlspecialchars(url_for('assets/js/sweetAlert2.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<script src="<?php echo htmlspecialchars(url_for('assets/js/bootstrap.bundle.min.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<script src="<?php echo htmlspecialchars(url_for('config/js/detailActivity.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
</body>
</html>
