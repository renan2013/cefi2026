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
                // Fetch testimonials from database
                $stmt_test = $pdo->query("SELECT * FROM testimonios ORDER BY created_at DESC");
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
                        $t_img = !empty($test['foto']) ? '../classbox/public/uploads/images/' . $test['foto'] : 'img/testimonial-1.jpg';
                        ?>
                        <div class="testimonial-item text-center">
                            <img class="border rounded-circle p-2 mx-auto mb-3" src="<?php echo htmlspecialchars($t_img); ?>" style="width: 80px; height: 80px; object-fit: cover;">
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
<!-- Testimonial End -->