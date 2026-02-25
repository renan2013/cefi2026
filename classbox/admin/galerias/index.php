<?php
session_start();
$page_title = 'Gestor de Galerías';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../config/database.php';

// Fetch the 'Graduaciones' category or create a 'Galerías' category if it doesn't exist
// For now, let's list all posts in the 'Graduaciones' category as these are our galleries.
try {
    $stmt_cat = $pdo->prepare("SELECT id_category FROM categories WHERE name LIKE '%Graduaciones%' LIMIT 1");
    $stmt_cat->execute();
    $category = $stmt_cat->fetch();
    $id_graduaciones = $category ? $category['id_category'] : 0;

    $stmt = $pdo->prepare("
        SELECT p.id_post, p.title, p.created_at, 
        (SELECT COUNT(*) FROM attachments WHERE id_post = p.id_post AND type = 'gallery_image') as photo_count
        FROM posts p
        WHERE p.id_category = ?
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([$id_graduaciones]);
    $galerias = $stmt->fetchAll();

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<div class="table-header">
    <h3>Listado de Galerías (Graduaciones)</h3>
    <a href="create.php" class="btn-create">+ Crear Nueva Galería</a>
</div>

<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Fecha</th>
            <th>Fotos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($galerias)): ?>
            <tr>
                <td colspan="4" style="text-align:center;">No hay galerías creadas. Crea una publicación en la categoría "Graduaciones" para empezar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($galerias as $gal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($gal['title']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($gal['created_at'])); ?></td>
                    <td><span class="badge bg-primary"><?php echo $gal['photo_count']; ?> fotos</span></td>
                    <td class="actions">
                        <a href="../posts/attachments.php?post_id=<?php echo $gal['id_post']; ?>" class="btn-attach"><i class="fa-solid fa-camera"></i> Gestionar Fotos</a>
                        <a href="../posts/edit.php?id=<?php echo $gal['id_post']; ?>">Editar</a>
                        <button type="button" class="btn-link delete" style="background:none; border:none; color:#dc3545; cursor:pointer;" onclick="confirmDelete(<?php echo $gal['id_post']; ?>, '<?php echo addslashes($gal['title']); ?>')">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: '¿Eliminar galería?',
        text: `Vas a borrar "${title}" y todas sus fotos. Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../posts/delete.php?id=${id}`;
        }
    });
}
</script>

<style>
.badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; background-color: #007bff; color: white; }
.btn-attach { background: #2D8FE2; color: white !important; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.9em; }
.btn-attach:hover { background: #1A74D2; }
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>