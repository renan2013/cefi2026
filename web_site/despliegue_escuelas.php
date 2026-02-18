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

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
  
                <h1 class="display-3 text-white animated slideInDown">Nombre de la escuela</h1>
    
</div>
<!-- Header End -->

<!-- Cursos Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Card de curso 1 -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card h-100">
                    <img src="img/course-1.jpg" class="card-img-top" alt="Imagen del Curso">
                    <div class="card-body">
                        <h5 class="card-title text-center">Nombre del Curso 1</h5>
                        <p class="card-text text-center"><small><i class="fa fa-clock text-primary me-2"></i>Duración</small></p>
                        <p class="card-text text-center"><small><i class="fa fa-user text-primary me-2"></i>Modalidad</small></p>
                    </div>
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
