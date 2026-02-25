<?php
require_once __DIR__ . '/classbox/config/database.php';
try {
    $pdo->exec("ALTER TABLE categories ADD COLUMN IF NOT EXISTS image VARCHAR(255) DEFAULT NULL");
    echo "Base de datos actualizada correctamente.";
} catch (PDOException $e) {
    echo "Error al actualizar la base de datos: " . $e->getMessage();
}
?>