<?php
require_once __DIR__ . '/../../config/database.php';

$post_id = $_POST['post_id'] ?? null;
$type = $_POST['type'] ?? null;
$value = '';
$error = '';

if (!$post_id || !$type) {
    header('Location: attachments.php?post_id=' . $post_id . '&error=' . urlencode('Datos incompletos.'));
    exit;
}

// Handle file uploads
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = __DIR__ . '/../../public/uploads/attachments/';
    // Ensure the directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = uniqid($type . '_', true) . '-' . basename($_FILES['file_upload']['name']);
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)) {
        $value = 'public/uploads/attachments/' . $file_name;
    } else {
        $error = 'Fallo al subir el archivo.';
    }
} else if ($type === 'youtube') {
    $value = $_POST['text_value'] ?? '';
    // Basic validation for YouTube URL/ID
    if (empty($value)) {
        $error = 'URL o ID de YouTube es obligatorio.';
    }
} else {
    $error = 'No se ha subido ningún archivo o el tipo no es YouTube.';
}

if (empty($error)) {
    try {
        $stmt = $pdo->prepare("INSERT INTO attachments (id_post, type, value, file_name, file_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$post_id, $type, $value, $value, $value]); // For YouTube, file_name and file_path store the URL/ID
        
        header('Location: attachments.php?post_id=' . $post_id . '&success=' . urlencode('Adjunto añadido exitosamente.'));
        exit;
    } catch (PDOException $e) {
        $error = 'Error de base de datos: ' . $e->getMessage();
    }
}

// If there's an error, redirect back with the error message
if (!empty($error)) {
    header('Location: attachments.php?post_id=' . $post_id . '&error=' . urlencode($error));
    exit;
}
?>