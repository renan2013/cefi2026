<?php
require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // First, delete all posts associated with this category
        $stmt_posts = $pdo->prepare("DELETE FROM posts WHERE id_category = ?");
        $stmt_posts->execute([$category_id]);

        // Then, delete the category itself
        $stmt_category = $pdo->prepare("DELETE FROM categories WHERE id_category = ?");
        $stmt_category->execute([$category_id]);

        // Commit the transaction
        $pdo->commit();

        header('Location: create.php?success=Category and associated posts deleted.');
        exit;
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        header('Location: create.php?error=Database error: ' . urlencode($e->getMessage()));
        exit;
    }
} else {
    header('Location: create.php?error=No category ID provided.');
    exit;
}
?>