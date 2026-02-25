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

    if (empty($title)) {
        $error = 'El título de la galería es obligatorio.';
    } else {
        try {
            $pdo->beginTransaction();

            // 1. Asegurar que existe la categoría 'Graduaciones'
            $stmt_cat = $pdo->prepare("SELECT id_category FROM categories WHERE name = 'Graduaciones' LIMIT 1");
            $stmt_cat->execute();
            $category = $stmt_cat->fetch();
            
            if (!$category) {
                $pdo->exec("INSERT INTO categories (name) VALUES ('Graduaciones')");
                $id_category = $pdo->lastInsertId();
            } else {
                $id_category = $category['id_category'];
            }

            // 2. Insertar la "publicación" de la galería
            $stmt = $pdo->prepare("INSERT INTO posts (title, id_category, synopsis, id_user) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $id_category, $synopsis, $_SESSION['user_id']]);
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
    <form action="create.php" method="POST">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="title">Título de la Graduación / Evento</label>
            <input type="text" id="title" name="title" placeholder="Ej: Graduación Técnicos 2025" required class="form-control">
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