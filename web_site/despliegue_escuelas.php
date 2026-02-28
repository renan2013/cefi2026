<?php
include 'header.php'; // already includes db_connect.php

$id_category = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch category name
try {
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id_category = ?");
    $stmt->execute([$id_category]);
    $category = $stmt->fetch();
    $nombre_escuela = $category ? $category['name'] : 'Escuela no encontrada';
} catch (PDOException $e) {
    $nombre_escuela = 'Error al cargar';
}
?>

<!-- Cursos Start -->
<div class="container-xxl py-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">Categoría</h6>
        <h1 class="mb-5"><?php echo htmlspecialchars($nombre_escuela); ?></h1>
    </div>

    <div class="container">
        <div class="row g-4">
            <?php
            try {
                // Fetch posts for this category, EXCLUDING those that are galleries (have gallery_image attachments)
                $stmt_posts = $pdo->prepare("
                    SELECT p.id_post, p.title, p.synopsis, p.main_image 
                    FROM posts p 
                    WHERE p.id_category = ? 
                    AND p.id_post NOT IN (SELECT id_post FROM attachments WHERE type = 'gallery_image')
                    ORDER BY p.created_at DESC
                ");
                $stmt_posts->execute([$id_category]);
                $posts = $stmt_posts->fetchAll();

                if (empty($posts)) {
                    echo '<div class="col-12 text-center"><p class="text-muted">No hay publicaciones disponibles en esta escuela actualmente.</p></div>';
                } else {
                    foreach ($posts as $index => $post) {
                        $delay = (0.1 * ($index % 4)) + 0.1;
                        
                        // Intelligent image path detection
                        $main_img = $post['main_image'];
                        if (!empty($main_img)) {
                            if (strpos($main_img, 'public/uploads/images/') !== false) {
                                $image_path = '../classbox/' . $main_img;
                            } else {
                                $image_path = '../classbox/public/uploads/images/' . $main_img;
                            }
                        } else {
                            $image_path = 'img/course-1.jpg'; // Default placeholder
                        }
                        ?>
                        <!-- Card de curso -->
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title text-left"><?php echo htmlspecialchars($post['title']); ?></h5>
                                    <p class="card-text text-left text-muted" style="font-size: 0.9rem;">
                                        <?php echo htmlspecialchars($post['synopsis'] ?: 'Sin descripción disponible.'); ?>
                                    </p>
                                    <a href="ver_detalles_escuela.php?id=<?php echo $post['id_post']; ?>" class="btn btn-primary btn-sm w-100 mt-auto">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } catch (PDOException $e) {
                echo '<div class="col-12 text-center text-danger"><p>Error al cargar las publicaciones.</p></div>';
            }
            ?>
        </div>

        <?php if (!empty($posts)): ?>
        <!-- Paginación Start (Estática por ahora) -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Paginación End -->
        <?php endif; ?>
    </div>
</div>

<style>
.course-card {
    border-radius: 15px !important;
    overflow: hidden;
    transition: transform 0.3s ease;
}
.course-card:hover {
    transform: translateY(-5px);
}
.course-card img {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}
</style>
<!-- Cursos End -->

<?php include 'footer.php'; ?>
