<?php
include 'header.php'; // Includes db_connect.php

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // 1. Fetch graduation details from independent table
    $stmt = $pdo->prepare("SELECT * FROM graduaciones WHERE id_graduacion = ?");
    $stmt->execute([$id]);
    $grad = $stmt->fetch();

    if (!$grad) {
        header('Location: 404.php');
        exit;
    }

    // 2. Fetch ALL attachments (Photos, Videos, PDFs)
    $stmt_att = $pdo->prepare("SELECT type, value FROM graduaciones_attachments WHERE id_graduacion = ? ORDER BY id_attachment ASC");
    $stmt_att->execute([$id]);
    $all_attachments = $stmt_att->fetchAll();

    // Organize attachments by type
    $photos = [];
    $extra_videos = [];
    $pdfs = [];

    foreach ($all_attachments as $att) {
        if ($att['type'] === 'gallery_image') $photos[] = $att['value'];
        elseif ($att['type'] === 'youtube') $extra_videos[] = $att['value'];
        elseif ($att['type'] === 'pdf') $pdfs[] = $att['value'];
    }

} catch (PDOException $e) {
    die("Error al cargar detalles de la graduación: " . $e->getMessage());
}
?>

<!-- Graduation Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/carousel-1.jpg'); background-size: cover;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown"><?php echo htmlspecialchars($grad['title']); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="graduaciones.php">Graduaciones</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php echo htmlspecialchars($grad['title']); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Graduation Header End -->

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-start text-primary pe-3">Detalles de la Ceremonia</h6>
                <h1 class="mb-4"><?php echo htmlspecialchars($grad['title']); ?></h1>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars($grad['synopsis'])); ?></p>
                
                <!-- Main Video (from table field) -->
                <?php if (!empty($grad['video_url'])): ?>
                    <div class="mb-5">
                        <h4 class="mb-3"><i class="fab fa-youtube text-danger me-2"></i>Video Principal de la Ceremonia</h4>
                        <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                            <?php 
                                $v_id = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $grad['video_url'], $matches)) { $v_id = $matches[1]; }
                            ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo $v_id; ?>" allowfullscreen></iframe>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Extra Videos (from attachments) -->
                <?php if (!empty($extra_videos)): ?>
                    <div class="mb-5">
                        <h4 class="mb-3"><i class="fab fa-youtube text-danger me-2"></i>Otros Videos de la Ceremonia</h4>
                        <div class="row g-3">
                            <?php foreach ($extra_videos as $video): ?>
                                <div class="col-md-6">
                                    <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                                        <?php 
                                            $ev_id = '';
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video, $matches)) { $ev_id = $matches[1]; }
                                        ?>
                                        <iframe src="https://www.youtube.com/embed/<?php echo $ev_id; ?>" allowfullscreen></iframe>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PDF Files Section -->
                <?php if (!empty($pdfs)): ?>
                    <div class="mb-5 bg-light p-4 rounded">
                        <h4 class="mb-3"><i class="fa fa-file-pdf text-danger me-2"></i>Documentos Descargables</h4>
                        <div class="row">
                            <?php foreach ($pdfs as $pdf): ?>
                                <div class="col-md-4 mb-2">
                                    <a href="../classbox/public/uploads/attachments/<?php echo htmlspecialchars($pdf); ?>" target="_blank" class="btn btn-outline-danger w-100 text-start">
                                        <i class="fa fa-download me-2"></i> Ver documento PDF
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Photo Gallery Section -->
                <?php if (!empty($photos)): ?>
                    <h4 class="mb-3"><i class="fa fa-images text-primary me-2"></i>Galería de Fotos</h4>
                    <div class="row g-3">
                        <?php foreach ($photos as $photo): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="../classbox/public/uploads/images/<?php echo htmlspecialchars($photo); ?>" data-lightbox="graduation-gallery" class="d-block shadow-sm rounded overflow-hidden photo-item">
                                    <img src="../classbox/public/uploads/images/<?php echo htmlspecialchars($photo); ?>" class="img-fluid" alt="Foto de graduación" style="height: 200px; width: 100%; object-fit: cover;">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 for gallery -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<style>
.photo-item { transition: transform 0.3s ease; }
.photo-item:hover { transform: scale(1.05); z-index: 10; }
</style>

<?php include 'footer.php'; ?>