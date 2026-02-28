<?php
try {
    $stmt_test = $pdo->query("SELECT * FROM testimonios WHERE video_iframe IS NOT NULL AND video_iframe != '' ORDER BY created_at DESC");
    $testimonios_video = $stmt_test->fetchAll();
} catch (PDOException $e) {
    $testimonios_video = [];
}
?>

<style>
    /* Proporción para la miniatura en el index */
    .custom-ratio-9-16 { 
        position: relative; 
        width: 100%; 
        padding-top: 100%; /* Proporción 1:1 para ganar anchura */
        background: #000; 
    }
    .custom-ratio-9-16 iframe { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100% !important; 
        height: 100% !important; 
        border: none; 
        object-fit: cover;
    }
    .video-overlay-play { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; transition: 0.3s; z-index: 10; }
    .video-clickable:hover .video-overlay-play { background: rgba(0,0,0,0.5); }
    .video-clickable:hover .video-overlay-play i { transform: scale(1.2); }
    .testimonial-carousel .owl-nav { display: flex; justify-content: center; margin-top: 20px; gap: 15px; }
    .testimonial-carousel .owl-nav button { font-size: 20px !important; color: #007bff !important; }
    
    /* Asegurar que la info esté siempre DEBAJO del video */
    .testimonial-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .testimonial-info {
        margin-top: 15px;
        width: 100%;
        text-align: center;
    }
</style>

<!-- Testimonial Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonios</h6>
            <h1 class="mb-5">Experiencias de Nuestros Estudiantes</h1>
        </div>
        
        <?php if (empty($testimonios_video)): ?>
            <div class="text-center bg-light p-5 rounded">
                <i class="fa fa-video fs-1 text-muted mb-3"></i>
                <p class="mb-0 text-muted">Próximamente compartiremos los videos de nuestros alumnos.</p>
            </div>
        <?php else: ?>
            <div class="owl-carousel testimonial-carousel position-relative">
                <?php foreach ($testimonios_video as $test):
                    $video_data = trim($test['video_iframe']);
                    $final_url = "";
                    
                    if (preg_match('/src=["\']([^"\']+)["\']/', $video_data, $matches)) {
                        $final_url = $matches[1];
                    } elseif (strpos($video_data, 'drive.google.com') !== false) {
                        if (preg_match('/(?:file\/d\/|id=)([^\/\?&]+)/', $video_data, $id_match)) {
                            $final_url = "https://drive.google.com/file/d/" . $id_match[1] . "/preview";
                            if (preg_match('/resourcekey=([^\?&"\' ]+)/', $video_data, $rk_match)) {
                                $final_url .= "?resourcekey=" . $rk_match[1];
                            }
                        }
                    }
                    
                    if (empty($final_url)) continue;
                ?>
                    <div class="testimonial-item text-center px-3">
                        <!-- Bloque del Video -->
                        <div class="testimonial-video mb-2 shadow rounded overflow-hidden video-clickable" 
                             data-video-url="<?php echo htmlspecialchars($final_url); ?>"
                             style="width: 280px; margin: 0 auto; border: 5px solid #fff; cursor: pointer; position: relative;">
                            
                            <div class="custom-ratio-9-16">
                                <iframe src="<?php echo htmlspecialchars($final_url); ?>" style="pointer-events: none;"></iframe>
                                <div class="video-overlay-play">
                                    <i class="fa fa-play-circle text-white" style="font-size: 3.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Bloque de Información (Forzado debajo) -->
                        <div class="testimonial-info">
                            <h5 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($test['nombre']); ?></h5>
                            <span class="text-primary text-uppercase small fw-bold"><?php echo htmlspecialchars($test['profesion']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="testimonialVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-0 mb-2 justify-content-end">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="background-color: #fff; opacity: 1; padding: 10px; border-radius: 50%;"></button>
            </div>
            <div class="modal-body p-0">
                <div style="position: relative; width: 100%; padding-top: 177.77%; background: #000;" class="shadow-lg">
                    <iframe id="modalIframe" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on('click', '.video-clickable', function() {
        const url = $(this).attr('data-video-url');
        if(!url) return;
        document.getElementById('modalIframe').src = url;
        const videoModal = new bootstrap.Modal(document.getElementById('testimonialVideoModal'));
        videoModal.show();
    });
    $('#testimonialVideoModal').on('hidden.bs.modal', function () {
        document.getElementById('modalIframe').src = '';
    });
});
</script>
<!-- Testimonial End -->