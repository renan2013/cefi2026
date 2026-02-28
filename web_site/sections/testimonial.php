<!-- Testimonial Start -->
<div class="container-xxl py-3 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonios</h6>
            <h1 class="mb-5">¡Nuestros estudiantes dicen!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            <?php
            try {
                // Fetch testimonials prioritizing those with video (video_iframe IS NOT NULL first)
                $stmt_test = $pdo->query("SELECT * FROM testimonios ORDER BY (video_iframe IS NOT NULL AND video_iframe != '') DESC, created_at DESC");
                $testimonios_home = $stmt_test->fetchAll();

                if (empty($testimonios_home)): ?>
                    <div class="testimonial-item text-center">
                        <img class="border rounded-circle p-2 mx-auto mb-3" src="img/testimonial-1.jpg" style="width: 80px; height: 80px;">
                        <h5 class="mb-0">Tu Nombre Aquí</h5>
                        <p>Estudiante</p>
                        <div class="testimonial-text bg-light text-center p-4">
                            <p class="mb-0">¡Pronto compartiremos las opiniones de nuestros alumnos!</p>
                        </div>
                    </div>
                <?php else:
                    foreach ($testimonios_home as $test):
                        $has_video = !empty($test['video_iframe']);
                        $t_img = !empty($test['foto']) ? '../classbox/public/uploads/images/' . $test['foto'] : 'img/testimonial-1.jpg';
                        ?>
                        <div class="testimonial-item text-center">
                            <?php if ($has_video): ?>
                                <!-- Video Container -->
                                <div class="testimonial-video mb-3 shadow-sm rounded overflow-hidden" style="max-width: 350px; margin: 0 auto;">
                                    <div class="ratio ratio-9x16">
                                        <?php 
                                            $video_data = $test['video_iframe'];
                                            // Si es un enlace de Drive (no un iframe)
                                            if (strpos($video_data, 'drive.google.com') !== false && strpos($video_data, '<iframe') === false) {
                                                // Extraer el ID del video y convertirlo a formato preview
                                                if (preg_match('/\/file\/d\/([^\/]+)/', $video_data, $matches)) {
                                                    $drive_id = $matches[1];
                                                    echo '<iframe src="https://drive.google.com/file/d/' . $drive_id . '/preview" allow="autoplay"></iframe>';
                                                } else {
                                                    echo '<p class="text-muted p-3">Enlace de Drive no válido</p>';
                                                }
                                            } elseif (strpos($video_data, '<iframe') !== false) {
                                                // Si ya es un iframe, lo mostramos (el CSS se encarga del tamaño)
                                                echo $video_data;
                                            } else {
                                                echo '<p class="text-muted p-3">Video no disponible</p>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Photo Container -->
                                <img class="border rounded-circle p-2 mx-auto mb-3" src="<?php echo htmlspecialchars($t_img); ?>" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endif; ?>

                            <h5 class="mb-0"><?php echo htmlspecialchars($test['nombre']); ?></h5>
                            <p><?php echo htmlspecialchars($test['profesion']); ?></p>
                            <div class="testimonial-text bg-light text-center p-4">
                                <p class="mb-0"><?php echo htmlspecialchars($test['comentario']); ?></p>
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
/* Asegurar que el iframe ocupe todo el contenedor ratio */
.testimonial-video iframe {
    width: 100% !important;
    height: 100% !important;
}
/* Estilo para los testimonios con video en el carrusel */
.testimonial-carousel .owl-item img {
    display: inline-block; /* Permitir que las fotos de testimonios normales no se estiren */
}
</style>
<!-- Testimonial End -->