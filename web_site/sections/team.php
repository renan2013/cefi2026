<!-- Team Start -->
<div class="container-xxl py-3">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructores</h6>
            <h1 class="mb-5">Expertos Instructores</h1>
        </div>
        <div class="row g-4">
            <?php
            try {
                // Fetch instructors from posts table, including the post title
                $stmt_team = $pdo->query("
                    SELECT id_post, title, instructor_name, instructor_title, instructor_photo 
                    FROM posts 
                    WHERE show_in_instructors = 1 
                    ORDER BY created_at DESC
                ");
                $instructors = $stmt_team->fetchAll();

                if (empty($instructors)): ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Nuestros instructores expertos aparecerán aquí pronto.</p>
                    </div>
                <?php else:
                    foreach ($instructors as $index => $inst):
                        $delay = (0.1 * ($index % 4)) + 0.1;
                        $inst_img = !empty($inst['instructor_photo']) ? '../classbox/public/uploads/images/' . $inst['instructor_photo'] : 'img/team-1.jpg';
                        ?>
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                            <div class="team-item bg-light">
                                <div class="overflow-hidden" style="height: 250px;">
                                    <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($inst_img); ?>" alt="<?php echo htmlspecialchars($inst['instructor_name']); ?>" style="object-fit: cover;">
                                </div>
                                <div class="text-center p-4">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($inst['instructor_name']); ?></h5>
                                    <small><?php echo htmlspecialchars($inst['instructor_title']); ?></small>
                                    <p class="mt-2 mb-0 text-primary small fw-bold"><?php echo htmlspecialchars($inst['title']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                endif;
            } catch (PDOException $e) {
                echo '<p class="text-danger">Error al cargar instructores</p>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Team End -->