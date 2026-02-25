<?php
session_start();
$page_title = 'Editar Galería';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../config/database.php';

$id_post = $_GET['id'] ?? 0;
$error = '';
$success = '';

// Fetch current details
try {
    $stmt = $pdo->prepare("SELECT title, synopsis FROM posts WHERE id_post = ?");
    $stmt->execute([$id_post]);
    $post = $stmt->fetch();

    if (!$post) {
        header('Location: index.php');
        exit;
    }

    // Fetch existing video URL (YouTube attachment)
    $stmt_video = $pdo->prepare("SELECT id_attachment, value FROM attachments WHERE id_post = ? AND type = 'youtube' LIMIT 1");
    $stmt_video->execute([$id_post]);
    $video = $stmt_video->fetch();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $synopsis = trim($_POST['synopsis'] ?? '');
    $video_url = trim($_POST['video_url'] ?? '');

    if (empty($title)) {
        $error = 'El título es obligatorio.';
    } else {
        try {
            $pdo->beginTransaction();

            // 1. Update post basic info
            $stmt_upd = $pdo->prepare("UPDATE posts SET title = ?, synopsis = ? WHERE id_post = ?");
            $stmt_upd->execute([$title, $synopsis, $id_post]);

            // 2. Handle video URL
            if (!empty($video_url)) {
                if ($video) {
                    $stmt_vid_upd = $pdo->prepare("UPDATE attachments SET value = ? WHERE id_attachment = ?");
                    $stmt_vid_upd->execute([$video_url, $video['id_attachment']]);
                } else {
                    $stmt_vid_ins = $pdo->prepare("INSERT INTO attachments (id_post, type, value) VALUES (?, 'youtube', ?)");
                    $stmt_vid_ins->execute([$id_post, $video_url]);
                }
            } elseif ($video) {
                // Remove video if empty
                $stmt_vid_del = $pdo->prepare("DELETE FROM attachments WHERE id_attachment = ?");
                $stmt_vid_del->execute([$video['id_attachment']]);
            }

            $pdo->commit();
            header('Location: index.php?success=' . urlencode('Galería actualizada con éxito.'));
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Error de base de datos: ' . $e->getMessage();
        }
    }
}
?>

<div class="styled-form">
    <h3>Editar Galería: <?php echo htmlspecialchars($post['title']); ?></h3>
    <form action="edit.php?id=<?php echo $id_post; ?>" method="POST">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="title">Título de la Graduación</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="synopsis">Descripción Corta</label>
            <textarea id="synopsis" name="synopsis" rows="3" class="form-control"><?php echo htmlspecialchars($post['synopsis']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="video_url">URL de Video (YouTube)</label>
            <input type="text" id="video_url" name="video_url" value="<?php echo htmlspecialchars($video['value'] ?? ''); ?>" placeholder="https://www.youtube.com/watch?v=..." class="form-control">
            <small>Copia y pega el enlace del video de la graduación.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Guardar Cambios</button>
            <a href="index.php" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>