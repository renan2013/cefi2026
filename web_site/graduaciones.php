<?php
include 'header.php'; // Includes db_connect.php

try {
    // Fetch posts that belong to gallery-related categories
    // or specifically have gallery/video attachments.
    $stmt_posts = $pdo->prepare("
        SELECT DISTINCT p.id_post, p.title, p.synopsis, p.main_image, p.created_at, c.name as cat_name
        FROM posts p
        JOIN categories c ON p.id_category = c.id_category
        LEFT JOIN attachments a ON p.id_post = a.id_post
        WHERE c.name LIKE '%Graduaciones%' 
           OR c.name LIKE '%Diplomado%'
           OR c.name LIKE '%Galería%'
           OR a.type IN ('gallery_image', 'youtube')
        ORDER BY p.created_at DESC
    ");
    $stmt_posts->execute();
    $graduations = $stmt_posts->fetchAll();

} catch (PDOException $e) {
    die("Error al cargar graduaciones: " . $e->getMessage());
}
?>

<!-- Graduaciones Start -->
<div class="container-xxl py-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">Galería de Eventos</h6>
        <h1 class="mb-5">Nuestras Graduaciones</h1>
    </div>

    <div class="container">
        <div class="row g-4">
            <?php if (empty($graduations)): ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <i class="fa fa-images fs-1 text-muted mb-3"></i>
                        <p class="text-muted">Próximamente estaremos compartiendo las fotos y videos de nuestras ceremonias de graduación.</p>
                        <a href="index.php" class="btn btn-primary mt-3">Volver al Inicio</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($graduations as $index => $grad): 
                    $delay = (0.1 * ($index % 3)) + 0.1;
                    $image_path = !empty($grad['main_image']) ? '../classbox/public/uploads/images/' . $grad['main_image'] : 'img/course-1.jpg';
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
            <?php endif; ?>
        </div>
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