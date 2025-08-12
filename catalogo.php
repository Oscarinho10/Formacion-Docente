<?php
include('config/conexion.php');
include('config/controller/catalogoController.php');
?>

<?php include('HeadAndFoot/header.php');
?>

<div class="container py-4">
    <div class="row">

        <?php if ($hayActividades): ?>
            <?php while ($fila = pg_fetch_assoc($resultado)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php
                        $img = isset($fila['url_imagen']) ? trim($fila['url_imagen']) : '';
                        if ($img === '' || $img === null) {
                            $src = BASE_URL . '/assets/img/placeholder.png';
                        } elseif (strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0 || strpos($img, '/') === 0) {
                            // Ya es URL absoluta o ruta con /
                            $src = $img[0] === '/' ? BASE_URL . $img : $img;
                        } else {
                            // Nombre suelto: apunta a la carpeta real de las imágenes subidas
                            $src = BASE_URL . '/uploads/imagenes/' . $img;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($src); ?>"
                            class="card-img-top"
                            alt="Imagen actividad"
                            onerror="this.onerror=null;this.src='<?php echo BASE_URL; ?>/assets/img/placeholder.png';">
                        <div class="card-body">
                            <h6 class="card-title"><?php echo htmlspecialchars($fila['nombre']); ?></h6>
                            <p class="card-text"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="./detailsActivity.php?id=<?php echo $fila['id_actividad']; ?>" class="btn btn-outline-secondary btn-sm">Detalles</a>
                                <button onclick="window.location.href='<?php echo BASE_URL; ?>/login.php'" class="btn btn-primary btn-sm">Pre-registrarse</button>
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