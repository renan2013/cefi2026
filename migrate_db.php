<?php
require_once __DIR__ . '/classbox/config/database.php';

try {
    // 1. Añadir la columna is_system si no existe
    $pdo->exec("ALTER TABLE categories ADD COLUMN IF NOT EXISTS is_system TINYINT(1) DEFAULT 0");
    echo "Columna 'is_system' añadida con éxito.
";

    // 2. Marcar la categoría 'Graduaciones' como sistema
    $pdo->exec("UPDATE categories SET is_system = 1 WHERE name = 'Graduaciones'");
    echo "Categoría 'Graduaciones' marcada como sistema.
";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>