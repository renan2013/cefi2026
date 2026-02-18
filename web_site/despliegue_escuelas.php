<?php
$escuelas = [
    1 => 'Diseño Web',
    2 => 'Diseño Gráfico',
    3 => 'Edición de Video',
    4 => 'Marketing Online'
];
$id_escuela = isset($_GET['id_escuela']) ? (int)$_GET['id_escuela'] : 0;
$nombre_escuela = isset($escuelas[$id_escuela]) ? $escuelas[$id_escuela] : 'Desconocida';

include 'header.php';
?>



<!-- Cursos Start -->
<div class="container-xxl py-5">

    <h3 class="display-6 text-center  animated slideInDown">Nombre de la escuela</h3>
    <div class="container">
        <div class="row g-4">


            <div class="card">
                <img src="img/course-1.jpg" class="card-img-top" alt="Descripción de la imagen">

                <div class="card-body">
                    <h5 class="card-title">Título del Producto</h5>

                    <p class="card-text">Esta es una descripción breve para convencer al usuario de hacer clic en el botón de abajo.</p>

                    <a href="#" class="btn btn-primary">Ver detalles</a>
                </div>
            </div>
            <!-- Fin de Card de curso 1 -->



        </div>

        <!-- Paginación Start -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Paginación End -->
    </div>
</div>
<!-- Cursos End -->

<?php include 'footer.php'; ?>