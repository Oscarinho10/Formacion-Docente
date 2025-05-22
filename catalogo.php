<?php
// catalogo.php
?>

<?php
include './config/conexion.php'; // o 'config/conexion.php' si lo pusiste en una carpeta
// Ya puedes usar $conn aquí para hacer consultas
?>

<?php include './HeadAndFoot/header.php'; ?>

<div class="container py-4">
    <div class="row">

        <!-- Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/600x300" class="card-img-top" alt="Curso IA">
                <div class="card-body">
                    <h6 class="card-title">Curso de Inteligencia Artificial IA</h6>
                    <p class="card-text">Descubre el poder de la Inteligencia Artificial y cómo está transformando el mundo. ¡El futuro es ahora!</p>
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-secondary btn-sm">Detalles</a>
                        <a href="./login.php" class="btn btn-primary btn-sm">Pre-registrarse</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include './HeadAndFoot/footer.php'; ?>