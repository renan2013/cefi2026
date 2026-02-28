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
                        ?>
                        <div class="testimonial-item text-center px-3">
                            <!-- Video Player Section -->
                            <div class="testimonial-video mb-4 shadow rounded overflow-hidden" style="max-width: 320px; margin: 0 auto; border: 5px solid #fff; background: #000; position: relative; height: 500px;">
                                <?php 
                                    // 1. Detectar si es un enlace de Drive (no un iframe)
                                    if (strpos($video_data, 'drive.google.com') !== false && strpos($video_data, '<iframe') === false) {
                                        if (preg_match('/(?:file\/d\/|id=)([^\/\?&]+)/', $video_data, $matches)) {
                                            $drive_id = $matches[1];
                                            $preview_url = "https://drive.google.com/file/d/" . $drive_id . "/preview";
                                            if (preg_match('/resourcekey=([^\?&]+)/', $video_data, $rk_matches)) {
                                                $preview_url .= "?resourcekey=" . $rk_matches[1];
                                            }
                                            echo '<iframe src="' . $preview_url . '" style="width:100%; height:100%; border:none;" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                                        }
                                    } 
                                    // 2. Si ya es un iframe
                                    elseif (strpos($video_data, '<iframe') !== false) {
                                        $clean_iframe = preg_replace('/width=["\']\d+["\']/', 'width="100%"', $video_data);
                                        $clean_iframe = preg_replace('/height=["\']\d+["\']/', 'height="100%"', $clean_iframe);
                                        $clean_iframe = str_replace('<iframe', '<iframe style="width:100%; height:100%; border:none;"', $clean_iframe);
                                        echo $clean_iframe;
                                    }
                                ?>
                            </div>
                            
                            <!-- Student Info Section -->
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

<style>
.testimonial-video { background-color: #000; }
.testimonial-video iframe { width: 100% !important; height: 100% !important; border: none; }
.testimonial-carousel .owl-dots { margin-top: 30px; }
</style>
<!-- Testimonial End -->