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

    // Fetch all attachments for this graduation
    $stmt_attach = $pdo->prepare("SELECT type, value, file_name FROM attachments WHERE id_post = ? ORDER BY id_attachment DESC");
    $stmt_attach->execute([$id_post]);
    $attachments = $stmt_attach->fetchAll();

    $gallery = array_filter($attachments, function($a) { return $a['type'] === 'gallery_image'; });
    $videos = array_filter($attachments, function($a) { return $a['type'] === 'youtube'; });

} catch (PDOException $e) {
    die("Error al cargar la galería: " . $e->getMessage());
}
?>

<div class="container-xxl py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="graduaciones.php">Graduaciones</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($grad['title']); ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Left Side: Image Carousel -->
            <div class="col-lg-8">
                <h1 class="mb-3"><?php echo htmlspecialchars($grad['title']); ?></h1>
                <p class="text-muted mb-4"><?php echo htmlspecialchars($grad['synopsis']); ?></p>

                <?php if (empty($gallery)): ?>
                    <div class="bg-light p-5 text-center rounded">
                        <i class="fa fa-camera-retro fs-1 text-muted mb-3"></i>
                        <p>Aún no hay fotos disponibles para esta graduación.</p>
                    </div>
                <?php else: ?>
                    <div class="owl-carousel graduation-carousel mb-3">
                        <?php foreach ($gallery as $img): ?>
                            <div class="item">
                                <img src="../classbox/public/uploads/attachments/<?php echo $img['value']; ?>" class="img-fluid rounded shadow" alt="Graduación">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Thumbnails / Navigation helper -->
                    <div class="row g-2 mt-2">
                        <?php foreach (array_slice($gallery, 0, 6) as $img): ?>
                            <div class="col-2">
                                <img src="../classbox/public/uploads/attachments/<?php echo $img['value']; ?>" class="img-fluid rounded" style="height: 60px; object-fit: cover; opacity: 0.7;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-5">
                    <?php echo $grad['content']; ?>
                </div>
            </div>

            <!-- Right Side: Video List -->
            <div class="col-lg-4">
                <div class="bg-light p-4 rounded shadow-sm sticky-top" style="top: 100px;">
                    <h4 class="mb-4 border-bottom pb-2"><i class="fa fa-video text-primary me-2"></i>Videos del Evento</h4>
                    
                    <?php if (empty($videos)): ?>
                        <p class="text-muted small">No se han subido videos de esta ceremonia.</p>
                    <?php else: ?>
                        <div class="video-list">
                            <?php foreach ($videos as $vid): 
                                // Extract YouTube ID
                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid['value'], $match)) {
                                    $yid = $match[1];
                                }
                                ?>
                                <div class="video-item mb-4">
                                    <?php if (isset($yid)): ?>
                                        <div class="ratio ratio-16x9 mb-2 rounded overflow-hidden shadow-sm">
                                            <iframe src="https://www.youtube.com/embed/<?php echo $yid; ?>" title="Video Graduación" allowfullscreen></iframe>
                                        </div>
                                    <?php endif; ?>
                                    <h6 class="small mb-0 text-dark"><?php echo htmlspecialchars($vid['file_name'] ?: 'Video de la Ceremonia'); ?></h6>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <div class="d-grid gap-2">
                        <a href="https://wa.me/50689929180?text=Hola%2C%20quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20las%20pr%C3%B3ximas%20graduaciones" class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Consultar por WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.graduation-carousel .item img {
    height: 500px;
    object-fit: contain;
    background-color: #000;
}
@media (max-width: 991px) {
    .graduation-carousel .item img { height: 350px; }
}
.video-item h6 { font-weight: 600; }
</style>

<script>
$(document).ready(function(){
  $(".graduation-carousel").owlCarousel({
      items: 1,
      nav: true,
      dots: true,
      autoplay: true,
      loop: true,
      navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
      animateOut: 'fadeOut'
  });
});
</script>

<?php include 'footer.php'; ?>