<!-- Categories Start -->
<div class="container-xxl pt-2 category">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Escuelas</h6>
            <h1 class="mb-5">Escuelas de Aprendizaje</h1>
        </div>
        <div class="row g-3">
            <?php
            try {
                // Fetch categories excluding gallery types, and count their posts
                $stmt_cats = $pdo->query("
                    SELECT c.id_category, c.name, c.image, 
                    (SELECT COUNT(*) FROM posts p WHERE p.id_category = c.id_category) as total_posts
                    FROM categories c
                    WHERE LOWER(c.name) NOT LIKE '%graduacion%' 
                      AND LOWER(c.name) NOT LIKE '%diplomado%' 
                      AND LOWER(c.name) NOT LIKE '%galería%'
                    ORDER BY c.name ASC
                ");
                $categories_home = $stmt_cats->fetchAll();

                foreach ($categories_home as $index => $cat):
                    $delay = (0.1 * ($index % 4)) + 0.1;
                    $cat_img = !empty($cat['image']) ? '../classbox/public/uploads/images/' . $cat['image'] : 'img/cat-1.jpg';
                    ?>
                    <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="<?php echo $delay; ?>s">
                        <a class="position-relative d-block overflow-hidden category-card" href="despliegue_escuelas.php?id=<?php echo $cat['id_category']; ?>">
                            <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($cat_img); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" style="height: 220px !important; object-fit: cover;">
                            <div class="category-gradient" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 80%);"></div>
                            <div class="text-center position-absolute bottom-0 start-0 w-100 py-2 px-3" style="margin: 1px; z-index: 2;">
                                <h5 class="m-0 text-white text-center"><?php echo htmlspecialchars($cat['name']); ?> - <?php echo $cat['total_posts']; ?></h5>
                            </div>
                        </a>
                    </div>
                <?php endforeach;
            } catch (PDOException $e) {
                echo '<p class="text-danger">Error al cargar categorías</p>';
            }
            ?>
        </div>
    </div>
</div>

<style>
.category-card { transition: transform 0.3s ease; border-radius: 8px; }
.category-card:hover { transform: scale(1.05); z-index: 5; }
</style>
<!-- Categories End -->