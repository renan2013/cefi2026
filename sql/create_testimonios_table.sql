-- Tabla para el módulo de testimonios
CREATE TABLE IF NOT EXISTS `testimonios` (
  `id_testimonio` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `profesion` VARCHAR(255) DEFAULT NULL,
  `comentario` TEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
