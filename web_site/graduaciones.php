<?php
include 'header.php'; // Includes db_connect.php

try {
    // Fetch ONLY from the independent graduaciones table
    $stmt_grad = $pdo->query("
        SELECT id_graduacion as id_post, title, synopsis, main_image, created_at 
        FROM graduaciones 
        ORDER BY created_at DESC
    ");
    $graduations = $stmt_grad->fetchAll();

} catch (PDOException $e) {
    die("Error al cargar graduaciones: " . $e->getMessage());
}
?>

<!-- Graduaciones Start -->
<div class="container-xxl py-5">
    <div class="container">
        <?php if (empty($graduations)): ?>
            <div class="col-12 text-center py-5">
                <div class="bg-light p-5 rounded">
                    <i class="fa fa-images fs-1 text-muted mb-3"></i>
                    <h1 class="mb-3">Próximamente</h1>
                    <p class="text-muted">Estaremos compartiendo las fotos y videos de nuestras ceremonias de graduación muy pronto.</p>
                    <a href="index.php" class="btn btn-primary mt-3">Volver al Inicio</a>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Galería de Eventos</h6>
                <h1 class="mb-5">Nuestras Graduaciones</h1>
            </div>
            <div class="row g-4">
                <?php foreach ($graduations as $index => $grad): 
                    $delay = (0.1 * ($index % 3)) + 0.1;
                    
                    // Intelligent image path detection
                    $main_img = $grad['main_image'];
                    if (!empty($main_img)) {
                        if (strpos($main_img, 'public/uploads/images/') !== false) {
                            $image_path = '../classbox/' . $main_img;
                        } else {
                            $image_path = '../classbox/public/uploads/images/' . $main_img;
                        }
                    } else {
                        $image_path = 'img/course-1.jpg'; // Default placeholder
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden graduation-post">
                            <a href="ver_graduacion.php?id=<?php echo $grad['id_post']; ?>" class="d-block overflow-hidden">
                                <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($grad['title']); ?>" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                            </a>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary px-2 py-1">Graduación</span>
                                </div>
                                <h5 class="card-title mb-3">
                                    <a href="ver_graduacion.php?id=<?php echo $grad['id_post']; ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($grad['title']); ?></a>
                                </h5>
                                <p class="card-text text-muted small mb-4">
                                    <?php echo htmlspecialchars($grad['synopsis'] ?: 'Mira las fotos y videos de esta ceremonia.'); ?>
                                </p>
                                <a href="ver_graduacion.php?id=<?php echo $grad['id_post']; ?>" class="btn btn-primary btn-sm w-100 py-2">Ver Galería <i class="fa fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.graduation-post {
    transition: all 0.3s ease;
}
.graduation-post:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
.graduation-post:hover img {
    transform: scale(1.1);
}
</style>
<!-- Graduaciones End -->
<!-- Graduaciones End -->

<?php include 'footer.php'; ?>