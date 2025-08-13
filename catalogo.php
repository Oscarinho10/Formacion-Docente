<?php
include('config/conexion.php');
include('config/controller/catalogoController.php'); // Debe llenar $hayActividades y $resultado
include('HeadAndFoot/header.php');

/**
 * Helpers seguros para rutas/URLs (por si no existen globalmente)
 */
if (!function_exists('url_for')) {
  function url_for($path) {
    // Usa la constante RUTA_BASE para construir rutas relativas al sitio
    return RUTA_BASE . '/' . ltrim($path, '/');
  }
}
if (!function_exists('resolve_image_src')) {
  function resolve_image_src($img) {
    // Sin valor -> placeholder
    if (!isset($img) || trim($img) === '') {
      return url_for('assets/img/placeholder.png');
    }
    $img = trim($img);

    // URL absoluta (http/https)
    if (preg_match('~^https?://~i', $img)) {
      return $img;
    }

    // Si empieza con slash: normaliza para que siempre incluya la subcarpeta (RUTA_BASE)
    if (isset($img[0]) && $img[0] === '/') {
      // Si ya incluye RUTA_BASE al inicio, dejar igual
      if (strpos($img, RUTA_BASE . '/') === 0) {
        return $img;
      }
      // De lo contrario, anteponer RUTA_BASE
      return url_for(ltrim($img, '/'));
    }

    // Si ya viene con 'uploads/imagenes/...'
    if (stripos($img, 'uploads/imagenes/') === 0) {
      return url_for($img);
    }

    // Último caso: sólo nombre de archivo
    return url_for('uploads/imagenes/' . $img);
  }
}
?>
<div class="container py-4">
  <div class="row">
    <?php if (!empty($hayActividades)): ?>
      <?php while ($fila = pg_fetch_assoc($resultado)): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <?php
              $img = isset($fila['url_imagen']) ? $fila['url_imagen'] : '';
              $src = resolve_image_src($img);
            ?>
            <img
              src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
              class="card-img-top"
              alt="Imagen actividad"
              onerror="this.onerror=null;this.src='<?php echo htmlspecialchars(url_for('assets/img/placeholder.png'), ENT_QUOTES, 'UTF-8'); ?>';"
            >
            <div class="card-body d-flex flex-column">
              <h6 class="card-title"><?php echo htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8'); ?></h6>
              <p class="card-text"><?php echo htmlspecialchars($fila['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
              <div class="mt-auto d-flex justify-content-between">
                <a href="<?php echo htmlspecialchars(url_for('detailsActivity.php?id='.(isset($fila['id_actividad'])?$fila['id_actividad']:0)), ENT_QUOTES, 'UTF-8'); ?>"
                   class="btn btn-outline-secondary btn-sm">Detalles</a>
                <button onclick="window.location.href='<?php echo htmlspecialchars(url_for('login.php'), ENT_QUOTES, 'UTF-8'); ?>'"
                        class="btn btn-primary btn-sm">Pre-registrarse</button>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <div class="alert alert-info" role="alert">
          <h5 class="mb-0">¡Por el momento no hay actividades disponibles!</h5>
          <p class="mb-0">Vuelve pronto para conocer las nuevas actividades formativas.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include('HeadAndFoot/footer.php'); ?>
