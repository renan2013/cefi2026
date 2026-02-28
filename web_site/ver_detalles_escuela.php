<?php 
include 'header.php'; // Includes db_connect.php

$id_post = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch post details and its category name
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name 
        FROM posts p 
        JOIN categories c ON p.id_category = c.id_category 
        WHERE p.id_post = ?
    ");
    $stmt->execute([$id_post]);
    $post = $stmt->fetch();

    if (!$post) {
        echo '<div class="container mt-5 text-center"><h1>Publicación no encontrada</h1><a href="index.php" class="btn btn-primary">Volver al inicio</a></div>';
        include 'footer.php';
        exit;
    }

    // Fetch attachments (PDFs and YouTube videos)
    $stmt_attach = $pdo->prepare("SELECT type, value, file_name FROM attachments WHERE id_post = ?");
    $stmt_attach->execute([$id_post]);
    $attachments = $stmt_attach->fetchAll();

    $pdf_attachments = array_filter($attachments, function($a) { return $a['type'] === 'pdf'; });
    $youtube_video = array_filter($attachments, function($a) { return $a['type'] === 'youtube'; });
    $youtube_url = !empty($youtube_video) ? reset($youtube_video)['value'] : null;

    // Process YouTube URL to embed format
    if ($youtube_url) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_url, $match)) {
            $youtube_id = $match[1];
        }
    }

} catch (PDOException $e) {
    die("Error al cargar los detalles: " . $e->getMessage());
}
?>

<style>
.rounded-custom {
    border-radius: 15px !important;
}
.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>

<div class="container mt-5">
    <div class="row g-4">
        <div class="col-lg-7 col-md-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Categorías</li>
                    <li class="breadcrumb-item active text-primary"><?php echo htmlspecialchars($post['category_name']); ?></li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-3" style="color: #07609c;"><i class="fa fa-graduation-cap me-3"></i><?php echo htmlspecialchars($post['title']); ?></h2>
            <p class="lead text-muted"><?php echo htmlspecialchars($post['synopsis']); ?></p>
            
            <hr class="my-4">
            
            <div class="post-content">
                <?php echo $post['content']; // Tinymce content is usually safe HTML ?>
            </div>
        </div>

        <div class="col-lg-4 offset-lg-1 col-md-12">
            <div class="card shadow-sm border-0 sticky-top rounded-custom overflow-hidden" style="top: 100px;">
                <?php if (isset($youtube_id)): ?>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" title="Video del curso" allowfullscreen></iframe>
                    </div>
                <?php elseif (!empty($post['main_image'])): 
                    // Intelligent image path detection
                    $main_img = $post['main_image'];
                    if (strpos($main_img, 'public/uploads/images/') !== false) {
                        $image_path = '../classbox/' . $main_img;
                    } else {
                        $image_path = '../classbox/public/uploads/images/' . $main_img;
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="Imagen del curso">
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title">Recursos del curso</h5>
                    
                    <?php if (empty($pdf_attachments)): ?>
                        <p class="card-text small text-muted">No hay documentos adjuntos disponibles.</p>
                    <?php else: ?>
                        <div class="d-grid gap-2">
                            <?php foreach ($pdf_attachments as $pdf): ?>
                                <a href="../classbox/public/uploads/attachments/<?php echo htmlspecialchars($pdf['value']); ?>" target="_blank" class="btn btn-outline-primary d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-file-earmark-pdf"></i> <?php echo htmlspecialchars($pdf['file_name'] ?: 'Descargar PDF'); ?></span>
                                    <span class="badge bg-secondary">PDF</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                      
                    <hr>
                    <?php 
                    $whatsapp_msg = urlencode("Hola, estoy interesado en matricularme en el curso: " . $post['title']);
                    ?>
                    <a href="https://wa.me/50689929180?text=<?php echo $whatsapp_msg; ?>" class="btn btn-success btn-lg w-100" target="_blank">Inscribirme ahora</a>
                </div>
                <div class="card-footer text-center bg-white border-0">
                    <small class="text-muted">Certificado incluido</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
