<?php
include 'header.php'; // Includes db_connect.php

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // 1. Fetch graduation details from independent table
    $stmt = $pdo->prepare("SELECT * FROM graduaciones WHERE id_graduacion = ?");
    $stmt->execute([$id]);
    $grad = $stmt->fetch();

    if (!$grad) {
        echo '<div class="container mt-5 text-center"><h1>Graduación no encontrada</h1><a href="graduaciones.php" class="btn btn-primary">Volver al listado</a></div>';
        include 'footer.php';
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

    // Process Main Video or first attachment video
    $youtube_url = !empty($grad['video_url']) ? $grad['video_url'] : (!empty($extra_videos) ? $extra_videos[0] : null);
    if ($youtube_url) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_url, $match)) {
            $youtube_id = $match[1];
        }
    }

} catch (PDOException $e) {
    die("Error al cargar detalles de la graduación: " . $e->getMessage());
}
?>

<style>
.rounded-custom {
    border-radius: 15px !important;
}
.photo-item {
    transition: transform 0.3s ease;
}
.photo-item:hover {
    transform: scale(1.05);
    z-index: 10;
}
</style>

<div class="container mt-5">
    <div class="row g-4">
        <div class="col-lg-7 col-md-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="graduaciones.php">Graduaciones</a></li>
                    <li class="breadcrumb-item active text-primary">Detalles</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-3" style="color: #07609c;"><i class="fa fa-graduation-cap me-3"></i><?php echo htmlspecialchars($grad['title']); ?></h2>
            <p class="lead text-muted"><?php echo nl2br(htmlspecialchars($grad['synopsis'])); ?></p>
            
            <hr class="my-4">
            
            <!-- Photo Gallery Section -->
            <?php if (!empty($photos)): ?>
                <h4 class="mb-3 text-primary"><i class="fa fa-images me-2"></i>Galería de Fotos</h4>
                <div class="row g-3">
                    <?php foreach ($photos as $photo): ?>
                        <div class="col-lg-4 col-md-6">
                            <a href="../classbox/public/uploads/images/<?php echo htmlspecialchars($photo); ?>" data-lightbox="graduation-gallery" class="d-block shadow-sm rounded overflow-hidden photo-item">
                                <img src="../classbox/public/uploads/images/<?php echo htmlspecialchars($photo); ?>" class="img-fluid" alt="Foto de graduación" style="height: 180px; width: 100%; object-fit: cover;">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Extra Videos (if any) -->
            <?php if (count($extra_videos) > ($grad['video_url'] ? 0 : 1)): ?>
                <h4 class="mt-5 mb-3 text-primary"><i class="fab fa-youtube me-2"></i>Más Videos</h4>
                <div class="row g-3">
                    <?php foreach ($extra_videos as $index => $video): 
                        if ($youtube_url === $video && $index === 0) continue; // Skip main video
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $v_match)):
                        ?>
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/<?php echo $v_match[1]; ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4 offset-lg-1 col-md-12">
            <div class="card shadow-sm border-0 sticky-top rounded-custom overflow-hidden" style="top: 100px;">
                <?php if (isset($youtube_id)): ?>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" title="Video de graduación" allowfullscreen></iframe>
                    </div>
                <?php elseif (!empty($grad['main_image'])): ?>
                    <img src="../classbox/public/uploads/images/<?php echo htmlspecialchars($grad['main_image']); ?>" class="card-img-top" alt="Portada de graduación">
                <?php else: ?>
                    <img src="img/carousel-1.jpg" class="card-img-top" alt="CEFI">
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title">Recursos del evento</h5>
                    
                    <?php if (empty($pdfs)): ?>
                        <p class="card-text small text-muted">No hay documentos adjuntos disponibles.</p>
                    <?php else: ?>
                        <div class="d-grid gap-2">
                            <?php foreach ($pdfs as $pdf): ?>
                                <a href="../classbox/public/uploads/attachments/<?php echo htmlspecialchars($pdf); ?>" target="_blank" class="btn btn-outline-primary d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-file-pdf me-2"></i> Documento PDF</span>
                                    <span class="badge bg-secondary">Descargar</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                      
                    <hr>
                    <?php 
                    $whatsapp_msg = urlencode("Hola, me gustaría solicitar más información sobre la graduación: " . $grad['title']);
                    ?>
                    <a href="https://wa.me/50689929180?text=<?php echo $whatsapp_msg; ?>" class="btn btn-success btn-lg w-100" target="_blank">Consultar por WhatsApp</a>
                </div>
                <div class="card-footer text-center bg-white border-0">
                    <small class="text-muted">Centro Educativo de Formación Integral</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 for gallery -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<?php include 'footer.php'; ?>