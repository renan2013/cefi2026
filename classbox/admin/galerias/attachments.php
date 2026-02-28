<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id_graduacion = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';

// Verificar que la graduación existe
try {
    $stmt = $pdo->prepare("SELECT title FROM graduaciones WHERE id_graduacion = ?");
    $stmt->execute([$id_graduacion]);
    $grad = $stmt->fetch();
    if (!$grad) {
        die("Graduación no encontrada.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Procesar eliminación de foto
if (isset($_GET['delete_id'])) {
    $id_foto = (int)$_GET['delete_id'];
    try {
        // Obtener ruta del archivo para borrarlo físicamente
        $stmt = $pdo->prepare("SELECT file_path FROM graduaciones_fotos WHERE id_foto = ?");
        $stmt->execute([$id_foto]);
        $foto = $stmt->fetch();
        if ($foto) {
            $file_to_delete = __DIR__ . '/../../public/uploads/images/' . $foto['file_path'];
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
            $pdo->prepare("DELETE FROM graduaciones_fotos WHERE id_foto = ?")->execute([$id_foto]);
            header("Location: attachments.php?id=$id_graduacion&success=" . urlencode('Foto eliminada correctamente.'));
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error al eliminar foto: " . $e->getMessage();
    }
}

// Procesar subida de múltiples fotos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fotos'])) {
    $upload_dir = __DIR__ . '/../../public/uploads/images/';
    $total_files = count($_FILES['fotos']['name']);
    $uploaded_count = 0;

    for ($i = 0; $i < $total_files; $i++) {
        if ($_FILES['fotos']['error'][$i] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['fotos']['name'][$i], PATHINFO_EXTENSION);
            $file_name = uniqid('grad_photo_', true) . '.' . $file_extension;
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $target_file)) {
                $stmt = $pdo->prepare("INSERT INTO graduaciones_fotos (id_graduacion, file_path) VALUES (?, ?)");
                $stmt->execute([$id_graduacion, $file_name]);
                $uploaded_count++;
            }
        }
    }
    if ($uploaded_count > 0) {
        header("Location: attachments.php?id=$id_graduacion&success=" . urlencode("$uploaded_count fotos subidas con éxito."));
        exit;
    }
}

$page_title = 'Gestionar Fotos de Graduación';
require_once __DIR__ . '/../partials/header.php';

// Obtener fotos actuales
$stmt_photos = $pdo->prepare("SELECT * FROM graduaciones_fotos WHERE id_graduacion = ? ORDER BY id_foto DESC");
$stmt_photos->execute([$id_graduacion]);
$photos = $stmt_photos->fetchAll();
?>

<div class="content">
    <h3>Gestionar Fotos: <?php echo htmlspecialchars($grad['title']); ?></h3>
    <a href="index.php" class="btn-cancel mb-4" style="display:inline-block; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> Volver al listado</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="styled-form mb-5">
        <h4>Subir Nuevas Fotos</h4>
        <form action="attachments.php?id=<?php echo $id_graduacion; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Selecciona una o varias imágenes</label>
                <input type="file" name="fotos[]" multiple accept="image/*" class="form-control" required>
                <small>Puedes seleccionar varias fotos a la vez.</small>
            </div>
            <button type="submit" class="btn-submit">Subir Fotos</button>
        </form>
    </div>

    <h4 class="mt-5">Fotos en este Álbum</h4>
    <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top:20px;">
        <?php if (empty($photos)): ?>
            <p class="text-muted">No hay fotos en este álbum aún.</p>
        <?php else: ?>
            <?php foreach ($photos as $photo): ?>
                <div class="photo-card" style="width: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 8px; text-align: center; background: #f9f9f9;">
                    <img src="../../public/uploads/images/<?php echo htmlspecialchars($photo['file_path']); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
                    <a href="attachments.php?id=<?php echo $id_graduacion; ?>&delete_id=<?php echo $photo['id_foto']; ?>" 
                       class="text-danger" 
                       onclick="return confirm('¿Eliminar esta foto permanentemente?')"
                       style="text-decoration: none; font-size: 0.9em;"><i class="fa fa-trash"></i> Eliminar</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>