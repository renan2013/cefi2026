<?php 
include 'header.php'; // Includes db_connect.php

$id_post = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch post details, its category name and category image
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, c.image as category_image 
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

    // Fetch attachments (PDFs and YouTube videos) - From Post AND its Category
    $stmt_attach = $pdo->prepare("
        SELECT type, value, file_name FROM attachments WHERE id_post = ?
        UNION ALL
        SELECT type, value, file_name FROM attachments WHERE id_category = ?
    ");
    $stmt_attach->execute([$id_post, $post['id_category']]);
    $attachments = $stmt_attach->fetchAll();

    $pdf_attachments = array_filter($attachments, function($a) { return $a['type'] === 'pdf'; });
    $youtube_attachments = array_filter($attachments, function($a) { return $a['type'] === 'youtube'; });

    // Determine fallback image
    $image_path = 'img/course-1.jpg'; // Default fallback
    if (!empty($post['main_image'])) {
        $main_img = $post['main_image'];
        if (strpos($main_img, 'public/uploads/images/') !== false) {
            $image_path = '../classbox/' . $main_img;
        } else {
            $image_path = '../classbox/public/uploads/images/' . $main_img;
        }
    } elseif (!empty($post['category_image'])) {
        $image_path = '../classbox/public/uploads/images/' . $post['category_image'];
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
.video-resource {
    margin-bottom: 15px;
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
                <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="Imagen del curso">
                
                <div class="card-body">
                    <h5 class="card-title mb-3">Recursos disponibles</h5>
                    
                    <!-- YouTube Videos -->
                    <?php if (!empty($youtube_attachments)): ?>
                        <?php foreach ($youtube_attachments as $vid): 
                            $vid_url = $vid['value'];
                            $vid_id = null;
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid_url, $match)) {
                                $vid_id = $match[1];
                            } elseif (strlen(trim($vid_url)) === 11) {
                                $vid_id = trim($vid_url);
                            }

                            if ($vid_id): ?>
                                <div class="video-resource">
                                    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden mb-2">
                                        <iframe src="https://www.youtube.com/embed/<?php echo $vid_id; ?>" title="Video" allowfullscreen></iframe>
                                    </div>
                                    <small class="text-muted d-block text-center mb-3"><i class="fab fa-youtube me-1"></i> Ver video explicativo</small>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- PDF Documents -->
                    <?php if (empty($pdf_attachments) && empty($youtube_attachments)): ?>
                        <p class="card-text small text-muted">No hay recursos adicionales disponibles.</p>
                    <?php else: ?>
                        <div class="d-grid gap-2">
                            <?php foreach ($pdf_attachments as $pdf): ?>
                                <a href="../classbox/public/uploads/attachments/<?php echo htmlspecialchars($pdf['value']); ?>" target="_blank" class="btn btn-outline-primary d-flex justify-content-between align-items-center btn-sm">
                                    <span><i class="fa fa-file-pdf me-2"></i> <?php echo htmlspecialchars($pdf['file_name'] ?: 'Descargar PDF'); ?></span>
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
