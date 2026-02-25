<?php
session_start();
$page_title = 'Crear Nueva Galería';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $synopsis = trim($_POST['synopsis'] ?? '');
    $video_url = trim($_POST['video_url'] ?? '');
    $main_image_path = '';

    if (empty($title)) {
        $error = 'El título de la galería es obligatorio.';
    } else {
        // Handle Main Image Upload
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../public/uploads/images/';
            $file_name = uniqid('gallery_', true) . '-' . basename($_FILES['main_image']['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file)) {
                $main_image_path = $file_name;
            }
        }

        try {
            $pdo->beginTransaction();
            
            // ... (Asegurar categoría)
            $stmt_cat = $pdo->prepare("SELECT id_category FROM categories WHERE name = 'Graduaciones' LIMIT 1");
            $stmt_cat->execute();
            $category = $stmt_cat->fetch();
            $id_category = $category ? $category['id_category'] : 0;
            if (!$category) {
                $pdo->exec("INSERT INTO categories (name) VALUES ('Graduaciones')");
                $id_category = $pdo->lastInsertId();
            }

            // 2. Insertar la publicación con la imagen principal
            $stmt = $pdo->prepare("INSERT INTO posts (title, id_category, synopsis, main_image, id_user) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $id_category, $synopsis, $main_image_path, $_SESSION['user_id']]);
            $id_post = $pdo->lastInsertId();

            // 3. Si hay video, insertarlo como adjunto
            if (!empty($video_url)) {
                $stmt_video = $pdo->prepare("INSERT INTO attachments (id_post, type, value) VALUES (?, 'youtube', ?)");
                $stmt_video->execute([$id_post, $video_url]);
            }

            $pdo->commit();
            header('Location: index.php?success=' . urlencode('Galería creada con éxito. Ahora puedes añadir las fotos.'));
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Error de base de datos: ' . $e->getMessage();
        }
    }
}
?>

<div class="styled-form">
    <h3>Nueva Galería de Graduación</h3>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="title">Título de la Graduación / Evento</label>
            <input type="text" id="title" name="title" placeholder="Ej: Graduación Técnicos 2025" required class="form-control">
        </div>

        <div class="form-group">
            <label for="main_image">Imagen Principal (Miniatura)</label>
            <input type="file" id="main_image" name="main_image" accept="image/*" class="form-control">
            <small>Esta imagen se usará como portada en el listado de graduaciones.</small>
        </div>

        <div class="form-group">
            <label for="synopsis">Descripción Corta</label>
            <textarea id="synopsis" name="synopsis" rows="3" class="form-control" placeholder="Breve resumen del evento..."></textarea>
        </div>

        <div class="form-group">
            <label for="video_url">URL de Video (YouTube)</label>
            <input type="text" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=..." class="form-control">
            <small>Copia y pega el enlace del video de la graduación.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Crear Galería y Continuar</button>
            <a href="index.php" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>