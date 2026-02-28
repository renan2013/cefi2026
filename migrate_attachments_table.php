<?php
require_once __DIR__ . '/classbox/config/database.php';

try {
    // 1. Quitar la restricción de clave foránea existente (si la tiene, para poder modificar la columna)
    // El nombre de la restricción según el esquema es attachments_ibfk_1
    try {
        $pdo->exec("ALTER TABLE attachments DROP FOREIGN KEY attachments_ibfk_1");
        echo "Restricción de clave foránea antigua eliminada.<br>";
    } catch (PDOException $e) {
        echo "Aviso: No se pudo eliminar la clave foránea (posiblemente ya no existe).<br>";
    }

    // 2. Hacer id_post nullable
    $pdo->exec("ALTER TABLE attachments MODIFY id_post INT(11) NULL");
    echo "Columna 'id_post' ahora permite valores nulos.<br>";

    // 3. Añadir id_category (si no existe)
    $pdo->exec("ALTER TABLE attachments ADD COLUMN IF NOT EXISTS id_category INT(11) NULL AFTER id_post");
    echo "Columna 'id_category' añadida o ya existía.<br>";

    // 4. Volver a añadir las claves foráneas
    try {
        $pdo->exec("ALTER TABLE attachments ADD CONSTRAINT fk_attachments_post FOREIGN KEY (id_post) REFERENCES posts(id_post) ON DELETE CASCADE");
        echo "Clave foránea para posts añadida.<br>";
    } catch (PDOException $e) {
        echo "Aviso: No se pudo añadir la clave foránea para posts.<br>";
    }

    try {
        $pdo->exec("ALTER TABLE attachments ADD CONSTRAINT fk_attachments_category FOREIGN KEY (id_category) REFERENCES categories(id_category) ON DELETE CASCADE");
        echo "Clave foránea para categorías añadida.<br>";
    } catch (PDOException $e) {
        echo "Aviso: No se pudo añadir la clave foránea para categorías.<br>";
    }

    echo "Migración completada con éxito.";

} catch (PDOException $e) {
    echo "Error crítico: " . $e->getMessage();
}
?>
