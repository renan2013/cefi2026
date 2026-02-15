<?php
session_start();
$page_title = 'Administrar Publicaciones';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../config/database.php';

$search_query = $_GET['search'] ?? '';

$sql = "
    SELECT 
        p.id_post, 
        p.title, 
        p.created_at, 
        c.name as category_name, 
        u.full_name as author_name 
    FROM posts p
    JOIN categories c ON p.id_category = c.id_category
    LEFT JOIN users u ON p.id_user = u.id_user
";

$params = [];

if (!empty($search_query)) {
    $sql .= " WHERE p.title LIKE ? OR p.content LIKE ? OR c.name LIKE ?";
    $params = ['%' . $search_query . '%', '%' . $search_query . '%', '%' . $search_query . '%'];
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

$post_count = count($posts);
?>

<div class="table-header">
    <form action="" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Buscar publicaciones..." value="<?php echo htmlspecialchars($search_query); ?>" class="form-control search-input">
        <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
    </form>
    <a href="create.php" class="btn-create">+ Crear Nueva Publicación</a>
</div>

<p>Total de publicaciones: <?php echo $post_count; ?></p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Publicado El</th>
            <th>Autor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($posts)): ?>
            <tr>
                <td colspan="6" style="text-align:center;">No se encontraron publicaciones.</td>
            </tr>
        <?php else: ?>
            <?php $counter = 1; foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['category_name']); ?></td>
                    <td><?php echo date('F j, Y', strtotime($post['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($post['author_name'] ?? 'Desconocido'); ?></td>
                    <td class="actions">
                        <!-- Debug: id_post for edit link: <?php echo htmlspecialchars($post['id_post']); ?> -->
                        <a href="attachments.php?post_id=<?php echo $post['id_post']; ?>" class="btn-attach "><i class="fa-solid fa-paperclip me-2"></i> Adjuntos</a>
                        <a href="edit.php?id=<?php echo $post['id_post']; ?>">Editar</a>
                        <a href="delete.php?id=<?php echo $post['id_post']; ?>" class="delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta publicación y todos sus adjuntos?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<style>
.table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.search-form { display: flex; flex-grow: 1; gap: 10px; margin-right: 20px; } /* Added flex-grow and margin-right */
.search-input { flex-grow: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
.btn-search { background: linear-gradient(135deg, #2D8FE2, #1A74D2); padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;text-decoration: none; color: white; }
.btn-search:hover { background-color: #0056b3; }
.btn-create { background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
.btn-create:hover { background-color: #218838; }
.btn-attach {
  background: linear-gradient(135deg, #2D8FE2, #1A74D2);
  color: #fff !important; /* Forzamos blanco siempre */
  padding: 6px 12px;
  text-decoration: none;
  border-radius: 6px;
  font-size: 0.9em;
  box-shadow: 0 2px 6px rgba(45, 143, 226, 0.2);
  transition: all 0.3s ease;
}

.btn-attach:hover {
  background: linear-gradient(135deg, #499DF0, #2D8FE2);
  transform: scale(1.03);
  box-shadow: 0 4px 10px rgba(45, 143, 226, 0.3);
  color: #fff !important;
}
</style>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>