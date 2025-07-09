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
                        <img src="<?php echo htmlspecialchars($fila['url_imagen']); ?>" class="card-img-top" alt="Imagen actividad">
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
