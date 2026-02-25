<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../auth/check_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_category = $_POST['id_category'] ?? 0;
    $new_name = trim($_POST['category_name'] ?? '');

    if ($id_category > 0 && !empty($new_name)) {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id_category = ?");
            $stmt->execute([$new_name, $id_category]);
            header('Location: create.php?success=' . urlencode('Categoría actualizada exitosamente.'));
            exit;
        } catch (PDOException $e) {
            header('Location: create.php?error=' . urlencode('Error al actualizar la categoría: ' . $e->getMessage()));
            exit;
        }
    }
}

header('Location: create.php?error=' . urlencode('Solicitud inválida para editar categoría.'));
exit;
?>