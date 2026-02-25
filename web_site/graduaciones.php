<?php
include 'header.php'; // Includes db_connect.php

try {
    // Fetch the ID of the 'Graduaciones' category
    $stmt_cat = $pdo->prepare("SELECT id_category FROM categories WHERE name LIKE '%Graduaciones%' LIMIT 1");
    $stmt_cat->execute();
    $category = $stmt_cat->fetch();
    $id_category = $category ? $category['id_category'] : 0;

    // Fetch all graduation posts
    $stmt_posts = $pdo->prepare("SELECT id_post, title, synopsis, main_image FROM posts WHERE id_category = ? ORDER BY created_at DESC");
    $stmt_posts->execute([$id_category]);
    $graduations = $stmt_posts->fetchAll();

} catch (PDOException $e) {
    die("Error al cargar graduaciones: " . $e->getMessage());
}
?>

<!-- Graduaciones Start -->
<div class="container-xxl py-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">Galería</h6>
        <h1 class="mb-5">Nuestras Graduaciones</h1>
    </div>

    <div class="container">
        <div class="row g-4">
            <?php if (empty($graduations)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Próximamente estaremos compartiendo las fotos de nuestras ceremonias de graduación.</p>
                </div>
            <?php else: ?>
                <?php foreach ($graduations as $index => $grad): 
                    $delay = (0.1 * ($index % 4)) + 0.1;
                    $image_path = !empty($grad['main_image']) ? '../classbox/public/uploads/images/' . $grad['main_image'] : 'img/course-1.jpg';
                    ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                            <div class="position-relative">
                                <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($grad['title']); ?>" style="height: 250px; object-fit: cover;">
                                <div class="bg-primary text-white position-absolute top-0 start-0 m-3 py-1 px-2 rounded small">Graduación</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($grad['title']); ?></h5>
                                <p class="card-text text-muted small"><?php echo htmlspecialchars($grad['synopsis']); ?></p>
                                <a href="ver_graduacion.php?id=<?php echo $grad['id_post']; ?>" class="btn btn-outline-primary btn-sm">Ver Fotos <i class="fa fa-camera ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Graduaciones End -->

<?php include 'footer.php'; ?>