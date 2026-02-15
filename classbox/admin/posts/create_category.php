<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../auth/check_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'] ?? '';

    if (!empty($category_name)) {
        try {
            // Check if category already exists
            $stmt_check = $pdo->prepare("SELECT id_category FROM categories WHERE name = ?");
            $stmt_check->execute([$category_name]);
            
            if ($stmt_check->fetch()) {
                header('Location: create.php?error=' . urlencode('La categoría ya existe.'));
                exit;
            } else {
                $stmt_insert = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
                $stmt_insert->execute([$category_name]);
                header('Location: create.php?success=' . urlencode('Categoría añadida exitosamente.'));
                exit;
            }
        } catch (PDOException $e) {
            header('Location: create.php?error=' . urlencode('Error de base de datos al añadir categoría: ' . $e->getMessage()));
            exit;
        }
    }
}

// Redirect back to the post creation page if not a POST request or category name is empty
header('Location: create.php?error=' . urlencode('Nombre de categoría vacío o solicitud inválida.'));
exit;
?>