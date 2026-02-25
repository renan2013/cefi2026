-- Script para añadir campos de instructor a las publicaciones
ALTER TABLE `posts` ADD COLUMN `instructor_name` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `posts` ADD COLUMN `instructor_title` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `posts` ADD COLUMN `instructor_photo` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `posts` ADD COLUMN `show_in_instructors` TINYINT(1) DEFAULT 0;
