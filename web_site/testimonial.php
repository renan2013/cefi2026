<?php include 'header.php'; ?>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/carousel-1.jpg'); background-size: cover;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Testimonios</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Testimonios</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<style>
    .custom-ratio-9-16 { 
        position: relative; 
        width: 100%; 
        padding-top: 100%; 
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
    /* Overlay invisible solo para capturar el click */
    .video-overlay-play { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0,0,0,0.1); 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        transition: 0.3s; 
        z-index: 10; 
    }
    .video-clickable:hover .video-overlay-play { background: rgba(0,0,0,0.3); }
    
    .testimonial-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
    }
    .testimonial-info {
        margin-top: 15px;
        width: 100%;
        text-align: center;
    }
</style>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Nuestra Comunidad</h6>
            <h1 class="mb-5">Todos los Testimonios en Video</h1>
        </div>
        
        <div class="row g-4">
            <?php
            try {
                // Fetch ALL unique testimonials with video
                $stmt_test = $pdo->query("SELECT * FROM testimonios WHERE video_iframe IS NOT NULL AND video_iframe != '' GROUP BY video_iframe, nombre ORDER BY created_at DESC");
                $testimonios_video = $stmt_test->fetchAll();

                foreach ($testimonios_video as $test):
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
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="testimonial-item text-center">
                            <div class="testimonial-video mb-2 shadow rounded overflow-hidden video-clickable" 
                                 data-video-url="<?php echo htmlspecialchars($final_url); ?>"
                                 style="width: 350px; max-width: 100%; margin: 0 auto; border: 5px solid #fff; cursor: pointer; position: relative;">
                                
                                <div class="custom-ratio-9-16">
                                    <iframe src="<?php echo htmlspecialchars($final_url); ?>" style="pointer-events: none;"></iframe>
                                    <div class="video-overlay-play">
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-info">
                                <h5 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($test['nombre']); ?></h5>
                                <span class="text-primary text-uppercase small fw-bold"><?php echo htmlspecialchars($test['profesion']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            } catch (PDOException $e) {
                echo '<p class="text-danger">Error al cargar testimonios</p>';
            }
            ?>
        </div>
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

<?php include 'footer.php'; ?>