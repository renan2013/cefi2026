-- Estructura definitiva para el módulo independiente de Graduaciones
-- Borrar tablas antiguas si existen para evitar conflictos
DROP TABLE IF EXISTS graduaciones_fotos;
DROP TABLE IF EXISTS graduaciones_attachments;

-- 1. Tabla de Graduaciones
CREATE TABLE IF NOT EXISTS graduaciones (
    id_graduacion INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    synopsis TEXT,
    main_image VARCHAR(255),
    video_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Adjuntos (Fotos, Videos, PDFs)
CREATE TABLE IF NOT EXISTS graduaciones_attachments (
    id_attachment INT AUTO_INCREMENT PRIMARY KEY,
    id_graduacion INT NOT NULL,
    type ENUM('pdf', 'youtube', 'gallery_image') NOT NULL DEFAULT 'gallery_image',
    value VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    FOREIGN KEY (id_graduacion) REFERENCES graduaciones(id_graduacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;