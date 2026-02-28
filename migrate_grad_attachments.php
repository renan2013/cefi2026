<?php
require_once __DIR__ . '/classbox/config/database.php';

try {
    // 1. Renombrar la tabla
    $pdo->exec("RENAME TABLE graduaciones_fotos TO graduaciones_attachments");
    
    // 2. Modificar columnas para que coincidan con la lógica de posts
    $pdo->exec("ALTER TABLE graduaciones_attachments 
                CHANGE id_foto id_attachment INT AUTO_INCREMENT,
                ADD COLUMN type ENUM('pdf','youtube','gallery_image') NOT NULL DEFAULT 'gallery_image',
                CHANGE file_path value VARCHAR(255) NOT NULL");
    
    echo "Tabla graduaciones_attachments actualizada con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>