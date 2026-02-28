-- Preparar la tabla de adjuntos para soportar categorías
-- 1. Eliminar la restricción actual para poder modificar la columna id_post
ALTER TABLE `attachments` DROP FOREIGN KEY `attachments_ibfk_1`;

-- 2. Hacer que id_post sea opcional (NULL)
ALTER TABLE `attachments` MODIFY `id_post` int(11) NULL;

-- 3. Añadir la columna id_category
ALTER TABLE `attachments` ADD COLUMN `id_category` int(11) NULL AFTER `id_post`;

-- 4. Volver a añadir la clave foránea de posts (ahora permitiendo NULL)
ALTER TABLE `attachments` ADD CONSTRAINT `attachments_ibfk_1` 
FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE;

-- 5. Añadir la nueva clave foránea para categorías
ALTER TABLE `attachments` ADD CONSTRAINT `fk_attachments_category` 
FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE;
