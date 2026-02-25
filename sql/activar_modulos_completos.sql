-- 1. CREAR TABLA DE TESTIMONIOS (Si no existe)
CREATE TABLE IF NOT EXISTS `testimonios` (
  `id_testimonio` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `profesion` VARCHAR(255) DEFAULT NULL,
  `comentario` TEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. REGISTRAR LOS MÓDULOS EN EL SISTEMA
INSERT IGNORE INTO `modules` (`name`, `display_name`, `description`) 
VALUES ('testimonios', 'Gestor de Testimonios', 'Administrar comentarios de estudiantes.');

INSERT IGNORE INTO `modules` (`name`, `display_name`, `description`) 
VALUES ('galerias', 'Gestor de Galerías', 'Administrar álbumes de fotos y graduaciones.');

-- 3. ASIGNAR PERMISOS A TODOS LOS USUARIOS ACTUALES
-- Esto garantiza que el botón aparezca en el menú lateral
INSERT IGNORE INTO `user_modules` (`id_user`, `id_module`) 
SELECT u.id_user, m.id_module 
FROM users u, modules m 
WHERE m.name IN ('testimonios', 'galerias');
