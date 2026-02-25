<?php
include 'header.php'; // Includes db_connect.php

$id_post = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch post details
    $stmt = $pdo->prepare("SELECT title, synopsis, content FROM posts WHERE id_post = ?");
    $stmt->execute([$id_post]);
    $grad = $stmt->fetch();

    if (!$grad) {
        header('Location: graduaciones.php');
        exit;
    }

    // Fetch gallery images
    $stmt_images = $pdo->prepare("SELECT value, file_name FROM attachments WHERE id_post = ? AND type = 'gallery_image' ORDER BY id_attachment DESC");
    $stmt_images->execute([$id_post]);
    $gallery = $stmt_images->fetchAll();

} catch (PDOException $e) {
    die("Error al cargar la galería: " . $e->getMessage());
}
?>

<!-- Gallery Detail Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Graduación</h6>
            <h1 class="mb-5"><?php echo htmlspecialchars($grad['title']); ?></h1>
            <p class="lead text-muted mx-auto" style="max-width: 800px;"><?php echo htmlspecialchars($grad['synopsis']); ?></p>
        </div>

        <div class="row g-4 mb-5">
            <?php if (empty($gallery)): ?>
                <div class="col-12 text-center text-muted">
                    <p>Aún no se han añadido fotos a esta galería.</p>
                </div>
            <?php else: ?>
                <?php foreach ($gallery as $index => $img): 
                    $delay = (0.1 * ($index % 4)) + 0.1;
                    $image_path = '../classbox/public/uploads/attachments/' . $img['value'];
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 wow zoomIn" data-wow-delay="<?php echo $delay; ?>s">
                        <div class="card shadow-sm border-0 h-100 overflow-hidden gallery-card">
                            <a href="<?php echo $image_path; ?>" target="_blank" class="gallery-link">
                                <img src="<?php echo $image_path; ?>" class="img-fluid w-100 h-100" alt="Foto Graduación" style="object-fit: cover; height: 200px;">
                                <div class="gallery-overlay">
                                    <i class="fa fa-search-plus text-white fs-4"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center">
            <a href="graduaciones.php" class="btn btn-primary px-5 py-3"><i class="fa fa-arrow-left me-2"></i> Volver a Graduaciones</a>
        </div>
    </div>
</div>

<style>
.gallery-card { transition: all 0.3s ease; border-radius: 8px; }
.gallery-card:hover { transform: scale(1.02); }
.gallery-link { position: relative; display: block; overflow: hidden; cursor: pointer; }
.gallery-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s ease;
}
.gallery-link:hover .gallery-overlay { opacity: 1; }
</style>
<!-- Gallery Detail End -->

<?php include 'footer.php'; ?>