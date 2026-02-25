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

// Handle file uploads (Multiple support)
if (isset($_FILES['file_upload'])) {
    $files = $_FILES['file_upload'];
    $uploaded_count = 0;
    
    // Check if it's multiple files or just one
    $file_array = is_array($files['name']) ? $files['name'] : [$files['name']];
    
    for ($i = 0; $i < count($file_array); $i++) {
        $error_code = is_array($files['error']) ? $files['error'][$i] : $files['error'];
        
        if ($error_code === UPLOAD_ERR_OK) {
            $tmp_name = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
            $name = is_array($files['name']) ? $files['name'][$i] : $files['name'];
            
            $upload_dir = __DIR__ . '/../../public/uploads/attachments/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_name = uniqid($type . '_', true) . '-' . basename($name);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO attachments (id_post, type, value, file_name) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$post_id, $type, $file_name, $file_name]);
                    $uploaded_count++;
                } catch (PDOException $e) {
                    $error = 'Error de base de datos: ' . $e->getMessage();
                    break;
                }
            }
        }
    }
    
    if ($uploaded_count > 0 && empty($error)) {
        header('Location: attachments.php?post_id=' . $post_id . '&success=' . urlencode("$uploaded_count archivos subidos correctamente."));
        exit;
    } else if (empty($error)) {
        $error = 'No se pudo subir ningún archivo.';
    }
} else if ($type === 'youtube') {
        $error = 'Error de base de datos: ' . $e->getMessage();
    }
}

// If there's an error, redirect back with the error message
if (!empty($error)) {
    header('Location: attachments.php?post_id=' . $post_id . '&error=' . urlencode($error));
    exit;
}
?>