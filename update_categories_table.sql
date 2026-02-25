-- Script para añadir soporte de imagen a las categorías
-- Importa este archivo en tu base de datos para habilitar las portadas de las Escuelas

ALTER TABLE `categories` ADD COLUMN IF NOT EXISTS `image` VARCHAR(255) DEFAULT NULL;
