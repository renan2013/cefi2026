<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$post_id = $_GET['post_id'] ?? null;
if (!$post_id) {
    header('Location: index.php');
    exit;
}

// Fetch post details and category name
$stmt = $pdo->prepare("SELECT p.title, c.name as category_name FROM posts p JOIN categories c ON p.id_category = c.id_category WHERE p.id_post = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();
if (!$post) {
    header('Location: index.php');
    exit;
}

$page_title = 'Attachments for: ' . htmlspecialchars($post['title']);

// Fetch existing attachments
$attach_stmt = $pdo->prepare("SELECT id_attachment, type, value FROM attachments WHERE id_post = ?");
$attach_stmt->execute([$post_id]);
$attachments = $attach_stmt->fetchAll();

require_once __DIR__ . '/../partials/header.php';
?>

<div class="attachments-container">
    <h3>Existing Attachments</h3>
    <?php if (empty($attachments)): ?>
        <p>No attachments found for this post.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($attachments as $att): ?>
                <li>
                    <strong><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $att['type']))); ?>:</strong>
                    <span><?php echo htmlspecialchars($att['value']); ?></span>
                    <a href="delete_attachment.php?id=<?php echo $att['id_attachment']; ?>&post_id=<?php echo $post_id; ?>" class="delete">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <h3>Add New Attachment</h3>
    
    <!-- Form for Gallery Images (only if category is Gallery) -->
    <?php if (stripos($post['category_name'], 'gallery') !== false): ?>
    <div class="upload-form">
        <h4>Upload Gallery Image</h4>
        <form action="add_attachment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="type" value="gallery_image">
            <input type="file" name="file_upload" required>
            <button type="submit">Upload Image</button>
        </form>
    </div>
    <?php endif; ?>

    <!-- Form for PDF -->
    <div class="upload-form">
        <h4>Upload PDF File</h4>
        <form action="add_attachment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="type" value="pdf">
            <input type="file" name="file_upload" accept=".pdf" required>
            <button type="submit">Upload PDF</button>
        </form>
    </div>

    <!-- Form for Slider Image -->
    <div class="upload-form">
        <h4>Upload Slider Image</h4>
        <form action="add_attachment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="type" value="slider_image">
            <input type="file" name="file_upload" accept="image/*" required>
            <button type="submit">Upload Slider Image</button>
        </form>
    </div>

    <!-- Form for YouTube Video -->
    <div class="upload-form">
        <h4>Add YouTube Video</h4>
        <form action="add_attachment.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="type" value="youtube">
            <input type="text" name="text_value" placeholder="Enter YouTube Video URL or ID" required>
            <button type="submit">Add Video</button>
        </form>
    </div>
</div>

<style>
.attachments-container { background-color: #fff; padding: 30px; border-radius: 8px; max-width: 800px; }
.attachments-container ul { list-style-type: none; padding: 0; }
.attachments-container li { background-color: #f8f9fa; padding: 10px 15px; border-radius: 4px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
.attachments-container li span { word-break: break-all; }
.attachments-container a.delete { color: #dc3545; text-decoration: none; font-weight: bold; }
.upload-form { border: 1px solid #e9ecef; padding: 20px; border-radius: 8px; margin-top: 20px; }
.upload-form h4 { margin-top: 0; }
.upload-form form { display: flex; gap: 10px; }
.upload-form input[type="file"], .upload-form input[type="text"] { flex-grow: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
.upload-form button { background-color: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; }
</style>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>