-- Añadir columna para video iframe de Google Drive en testimonios
ALTER TABLE testimonios ADD COLUMN video_iframe TEXT DEFAULT NULL;