<!-- Carousel Start -->
<div class="container-fluid p-0 mb-3">
    <div class="owl-carousel header-carousel position-relative">
        <?php
        try {
            // Fetch posts that have slider images and their category
            $stmt_slider = $pdo->query("
                SELECT p.id_post, p.title, p.synopsis, a.value, c.name as cat_name
                FROM posts p 
                JOIN attachments a ON p.id_post = a.id_post 
                JOIN categories c ON p.id_category = c.id_category
                WHERE a.type = 'slider_image' 
                ORDER BY p.created_at DESC
            ");
            $slides = $stmt_slider->fetchAll();

            foreach ($slides as $slide): 
                // Determine correct detail page
                $is_gallery = (stripos($slide['cat_name'], 'Graduaciones') !== false || stripos($slide['cat_name'], 'Diplomado') !== false || stripos($slide['cat_name'], 'Galería') !== false);
                $detail_page = $is_gallery ? 'ver_graduacion.php' : 'ver_detalles_escuela.php';
                ?>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid w-100" src="../classbox/public/uploads/attachments/<?php echo $slide['value']; ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>" style="height: 80vh; object-fit: cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end" style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 80, 40, 0.5) 15%, transparent 35%);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8" style="margin-top: auto;">
                                <h3 class="display-4 text-white animated slideInDown" style="font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);"><?php echo htmlspecialchars($slide['title']); ?></h3>
                                <p class="fs-5 text-white mb-4 pb-2"><?php echo htmlspecialchars($slide['synopsis']); ?></p>
                                <a href="<?php echo $detail_page; ?>?id=<?php echo $slide['id_post']; ?>" class="btn btn-primary py-md-3 px-md-5 animated slideInRight">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; 
        } catch (PDOException $e) {
            echo '<!-- Error loading slider: ' . $e->getMessage() . ' -->';
        }
        ?>
    </div>
</div>
<!-- Carousel End -->