<style>
/* Estilos para el Carrusel de Testimonios de Video */
.custom-ratio-9-16 {
    position: relative;
    width: 100%;
    padding-top: 177.77%;
    background: #000;
}
.custom-ratio-9-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
    border: none;
}
.video-overlay-play {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.3s;
    z-index: 10;
}
.video-clickable:hover .video-overlay-play {
    background: rgba(0,0,0,0.4);
}
.video-clickable:hover .video-overlay-play i {
    transform: scale(1.2);
}
.testimonial-carousel .owl-nav {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    gap: 15px;
}
.testimonial-carousel .owl-nav button { 
    font-size: 20px !important; 
    color: #007bff !important; 
    background: none !important;
    border: none !important;
}
.testimonial-carousel .owl-dots { margin-top: 30px; }
</style>

<!-- Testimonial Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonios</h6>
            <h1 class="mb-5">Experiencias de Nuestros Estudiantes</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            <?php
            try {
                // Fetch ONLY testimonials with video
                $stmt_test = $pdo->query("SELECT * FROM testimonios WHERE video_iframe IS NOT NULL AND video_iframe != '' ORDER BY created_at DESC");
                $testimonios_video = $stmt_test->fetchAll();

                if (empty($testimonios_video)): ?>
                    <div class="testimonial-item text-center">
                        <div class="bg-light p-4 rounded text-center">
                            <i class="fa fa-video fs-1 text-muted mb-3"></i>
                            <p class="mb-0 text-muted">Próximamente compartiremos los videos de nuestros alumnos.</p>
                        </div>
                    </div>
                <?php else:
                    foreach ($testimonios_video as $test):
                        $video_data = trim($test['video_iframe']);
                        $preview_url = "";
                        
                        // Extraer URL del video para el modal
                        if (strpos($video_data, 'drive.google.com') !== false) {
                            if (preg_match('/(?:file\/d\/|id=)([^\/\?&]+)/', $video_data, $matches)) {
                                $drive_id = $matches[1];
                                $preview_url = "https://drive.google.com/file/d/" . $drive_id . "/preview";
                                if (preg_match('/resourcekey=([^\?&]+)/', $video_data, $rk_matches)) {
                                    $preview_url .= "?resourcekey=" . $rk_matches[1];
                                }
                            }
                        } elseif (preg_match('/src=["\']([^"\']+)["\']/', $video_data, $src_matches)) {
                            $preview_url = $src_matches[1];
                        }
                        
                        if (empty($preview_url)) continue;
                        ?>
                        <div class="testimonial-item text-center px-3">
                            <div class="testimonial-video mb-4 shadow rounded overflow-hidden video-clickable" 
                                 onclick="openVideoModal('<?php echo $preview_url; ?>')"
                                 style="max-width: 280px; margin: 0 auto; border: 5px solid #fff; cursor: pointer; position: relative;">
                                
                                <div class="custom-ratio-9-16">
                                    <iframe src="<?php echo $preview_url; ?>" style="pointer-events: none;"></iframe>
                                    <div class="video-overlay-play">
                                        <i class="fa fa-play-circle text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="testimonial-info">
                                <h5 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($test['nombre']); ?></h5>
                                <span class="text-primary text-uppercase small fw-bold"><?php echo htmlspecialchars($test['profesion']); ?></span>
                            </div>
                        </div>
                    <?php endforeach;
                endif;
            } catch (PDOException $e) {
                echo '<p class="text-danger">Error al cargar testimonios</p>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="testimonialVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 500px;">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-0 mb-2">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="custom-ratio-9-16 shadow-lg">
                    <iframe id="modalIframe" src="" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openVideoModal(url) {
    if(!url) return;
    const modalElement = document.getElementById('testimonialVideoModal');
    const iframe = document.getElementById('modalIframe');
    const finalUrl = url.includes('?') ? url + '&autoplay=1' : url + '?autoplay=1';
    iframe.src = finalUrl;
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

document.getElementById('testimonialVideoModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalIframe').src = '';
});
</script>
<!-- Testimonial End -->