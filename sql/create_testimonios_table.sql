-- 1. Crear tabla de testimonios
CREATE TABLE IF NOT EXISTS `testimonios` (
  `id_testimonio` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `profesion` VARCHAR(255) DEFAULT NULL,
  `comentario` TEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Registrar el módulo en el sistema
INSERT IGNORE INTO `modules` (`name`, `display_name`, `description`) 
VALUES ('testimonios', 'Gestor de Testimonios', 'Administrar comentarios de estudiantes.');

-- 3. Asignar permisos al superadmin
INSERT IGNORE INTO `user_modules` (`id_user`, `id_module`) 
SELECT id_user, (SELECT id_module FROM modules WHERE name = 'testimonios') 
FROM users WHERE role = 'superadmin';
