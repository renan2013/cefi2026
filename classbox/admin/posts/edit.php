<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$page_title = 'Edit Post';
$error = '';
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    header('Location: index.php');
    exit;
}

// Fetch categories for the dropdown
$category_stmt = $pdo->query("SELECT id_category, name FROM categories ORDER BY name ASC");
$categories = $category_stmt->fetchAll();

// Handle form submission for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category_id = $_POST['category_id'] ?? null;
    $synopsis = $_POST['synopsis'] ?? '';
    $content = $_POST['content'] ?? '';
    $orden = $_POST['orden'] ?? 0; // Captura el nuevo campo 'orden'
    $current_image_path = $_POST['current_image_path'] ?? '';

    if (empty($title) || empty($category_id)) {
        $error = 'Title and Category are required.';
    } else {
        $main_image_path = $current_image_path;

        // Handle new file upload
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            // Optional: Delete the old image file if a new one is uploaded
            if (!empty($current_image_path) && file_exists(__DIR__ . '/../../' . $current_image_path)) {
                unlink(__DIR__ . '/../../' . $current_image_path);
            }

            $upload_dir = __DIR__ . '/../../public/uploads/images/';
            $file_name = uniqid('post_', true) . '-' . basename($_FILES['main_image']['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file)) {
                $main_image_path = 'public/uploads/images/' . $file_name;
            } else {
                $error = 'Failed to upload new main image.';
            }
        }

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare(
                    "UPDATE posts SET title = ?, id_category = ?, synopsis = ?, content = ?, main_image = ?, orden = ? WHERE id_post = ?"
                );
                $stmt->execute([$title, $category_id, $synopsis, $content, $main_image_path, $orden, $post_id]);
                $success_message = 'Post updated successfully!';
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Fetch current post data
try {
    $stmt = $pdo->prepare("SELECT *, orden FROM posts WHERE id_post = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();
    if (!$post) {
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

require_once __DIR__ . '/../partials/header.php';
?>

<form action="edit.php?id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data" class="styled-form">
    <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <input type="hidden" name="current_image_path" value="<?php echo htmlspecialchars($post['main_image']); ?>">

    <div class="form-group">
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id_category']; ?>" <?php echo ($post['id_category'] == $category['id_category']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>

    <div class="form-group">
        <label for="synopsis">Synopsis</label>
        <textarea id="synopsis" name="synopsis" rows="3"><?php echo htmlspecialchars($post['synopsis']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="content">Main Content</label>
        <textarea id="content" name="content" rows="10"><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="main_image">Change Main Image</label>
        <?php if (!empty($post['main_image'])): ?>
            <div class="current-image">
                <img src="<?php echo BASE_URL . '/' . htmlspecialchars($post['main_image']); ?>" alt="Current Image" height="100">
                <p>Current image. Upload a new file below to replace it.</p>
            </div>
        <?php endif; ?>
        <input type="file" id="main_image" name="main_image">
    </div>

    <div class="form-group">
        <label for="orden">Orden de Visualización</label>
        <input type="number" id="orden" name="orden" value="<?php echo htmlspecialchars($post['orden'] ?? 0); ?>" class="form-control">
        <small>Número para ordenar las publicaciones (menor número = primero).</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-submit">Update Post</button>
        <a href="index.php" class="btn-cancel">Cancel</a>
    </div>
</form>

<style>
/* Using styles from previous forms for consistency */
.styled-form { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 800px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-weight: 500; margin-bottom: 8px; }
.form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
.form-actions { margin-top: 30px; }
.btn-submit { background-color: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
.btn-cancel { color: #6c757d; text-decoration: none; margin-left: 15px; }
.error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
.success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
.current-image { margin-bottom: 15px; }
.current-image p { font-style: italic; color: #666; margin: 5px 0 0 0; }
</style>

<!-- TinyMCE -->
<script src="<?php echo BASE_URL; ?>/admin/assets/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
      selector: 'textarea#content',
      plugins: 'code table lists image link',
      toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image',
      
      // Image Upload Configuration
      images_upload_url: 'image_uploader.php',
      automatic_uploads: true,
      file_picker_types: 'image',
      
      // Crucial for correct image display
      relative_urls: false,
      remove_script_host: false,
      convert_urls: false
    });
  });
</script>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>