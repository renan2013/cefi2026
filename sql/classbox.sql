-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-02-2026 a las 20:55:33
-- Versión del servidor: 11.8.3-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u822406629_classboxnuevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attachments`
--

CREATE TABLE `attachments` (
  `id_attachment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `type` enum('pdf','youtube','slider_image','gallery_image') NOT NULL,
  `value` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `attachments`
--

INSERT INTO `attachments` (`id_attachment`, `id_post`, `type`, `value`, `file_name`, `file_path`) VALUES
(24, 39, 'slider_image', 'slider_image_69a3212f7ed7e6.72112523-Gemini_Generated_Image_sgia1nsgia1nsgia.png', 'Gemini_Generated_Image_sgia1nsgia1nsgia.png', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id_category`, `name`, `image`) VALUES
(14, 'Técnicos', 'cat_69a31ec85ba331.39634806-excell.png'),
(16, 'Auxiliares', NULL),
(17, 'Cursos Libres', 'cat_699f4c59364488.47979941-master_cursos_libres.png'),
(18, 'Técnicos Especializados', NULL),
(19, 'Talleres y Capacitaciones', NULL),
(24, 'Diplomados', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_cliente`
--

CREATE TABLE `datos_cliente` (
  `id_cliente_data` int(11) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `whatsapp_country_code` varchar(10) DEFAULT NULL,
  `whatsapp_number` varchar(50) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_maps_url` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_cliente`
--

INSERT INTO `datos_cliente` (`id_cliente_data`, `logo_path`, `whatsapp_country_code`, `whatsapp_number`, `facebook_url`, `youtube_url`, `instagram_url`, `tiktok_url`, `address`, `google_maps_url`, `email`, `phone`, `updated_at`) VALUES
(1, 'public/uploads/client_data/logo_6884737aeb721.png', '506', '87220999', 'https://www.facebook.com/unela.univ', '', '', '', 'Costado oeste de la Clínica Bíblica\r\nTorre Omega piso 9, Costa Rica', '', 'unela.contacto@unela.ac.cr', '+(506) 22217870 / +(506) 22212502', '2025-08-01 03:51:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_matricula`
--

CREATE TABLE `formulario_matricula` (
  `id_matricula` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `programa` varchar(255) NOT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  `codigo_pais` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `whatsapp` varchar(50) NOT NULL,
  `documentos` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduaciones`
--

CREATE TABLE `graduaciones` (
  `id_graduacion` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `synopsis` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `graduaciones`
--

INSERT INTO `graduaciones` (`id_graduacion`, `title`, `synopsis`, `main_image`, `video_url`, `created_at`, `id_user`) VALUES
(1, 'Graduacion febrero 2026', 'descripcion corta', 'grad_cover_69a2f7c8b6f5d0.90504200-logo_cefi.png', '', '2026-02-28 14:12:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduaciones_attachments`
--

CREATE TABLE `graduaciones_attachments` (
  `id_attachment` int(11) NOT NULL,
  `id_graduacion` int(11) NOT NULL,
  `type` enum('pdf','youtube','gallery_image') NOT NULL DEFAULT 'gallery_image',
  `value` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `graduaciones_attachments`
--

INSERT INTO `graduaciones_attachments` (`id_attachment`, `id_graduacion`, `type`, `value`, `display_order`) VALUES
(1, 1, 'gallery_image', 'grad_photo_69a2fb64da79b9.16162774.png', 0),
(2, 1, 'gallery_image', 'grad_photo_69a2fb64dac668.40214146.png', 0),
(3, 1, 'gallery_image', 'grad_photo_69a2fb64db4943.44436744.png', 0),
(4, 1, 'youtube', 'https://youtu.be/w46bWxS9IjY?list=RDMMkntzQiaFzOQ', 0),
(5, 1, 'pdf', 'grad_pdf_69a2fbb1b76ce2.49781836-siete-reglas-de-oro-para-vivir-en-pareja.pdf', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `title`, `url`, `display_order`, `parent_id`) VALUES
(12, 'Quienes Somos', 'about.php', 5, NULL),
(21, 'Contacto', 'contact.php', 6, NULL),
(47, 'CEFI Virtual', 'https://ceficr.com/virtual/', 0, NULL),
(48, 'Categorías', 'index.php', 0, NULL),
(49, 'Graduaciones', 'graduaciones.php', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `id_module` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`id_module`, `name`, `display_name`, `description`) VALUES
(1, 'posts', 'Gestor de Publicaciones', 'Crear, editar y eliminar publicaciones del blog.'),
(2, 'admisiones', 'Gestor de Admisiones', 'Gestiona las solicitudes de matrícula recibidas.'),
(3, 'menus', 'Gestor de Menús', 'Controlar la navegación del sitio web principal.'),
(4, 'users', 'Gestor de Usuarios', 'Administrar usuarios administradores (no superadministradores).'),
(5, 'client_data', 'Datos Cliente', 'Gestionar la información de contacto y redes sociales del cliente.'),
(6, 'galerias', 'Gestor de Galerías', 'Administrar álbumes de fotos y graduaciones independientes.'),
(7, 'testimonios', 'Gestor de Testimonios', 'Administrar comentarios de estudiantes.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `synopsis` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `orden` int(11) DEFAULT 0,
  `instructor_name` varchar(255) DEFAULT NULL,
  `instructor_title` varchar(255) DEFAULT NULL,
  `instructor_photo` varchar(255) DEFAULT NULL,
  `show_in_instructors` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id_post`, `id_category`, `title`, `synopsis`, `content`, `main_image`, `created_at`, `id_user`, `orden`, `instructor_name`, `instructor_title`, `instructor_photo`, `show_in_instructors`) VALUES
(39, 17, 'Gestión del talento humano', 'Tiene como objetivo desarrollar estudios formales sobre los procesos y gestión de la organización en sus diferentes niveles.', '<h4><big><strong>Descripci&oacute;n&nbsp;</strong></big></h4>\r\n<p><big>Tiene como objetivo el desarrollo de las habilidades y destrezas para efectuar el &oacute;ptimo desempe&ntilde;o de los colaboradores que integran una organizaci&oacute;n.</big></p>\r\n<p>&nbsp;</p>\r\n<hr>\r\n<h4><big><strong>Duraci&oacute;n del Curso</strong></big></h4>\r\n<p><big>8 meses con una duraci&oacute;n de 2 horas y media de clase por semana sincr&oacute;nica, y&nbsp; 2 horas y media de trabajo en casa por semana asincr&oacute;nica.</big></p>\r\n<h2>&nbsp;</h2>\r\n<hr>\r\n<h4><big><strong>Conocimientos a adquirir&nbsp;</strong></big></h4>\r\n<ul>\r\n<li><big>Dise&ntilde;ar, implementar y administrar los procesos de Gesti&oacute;n del Talento Humano (Planificaci&oacute;n, Formaci&oacute;n y Desarrollo, Reclutamiento y Selecci&oacute;n, Compensaci&oacute;n y beneficios, an&aacute;lisis de puestos, evaluaci&oacute;n del desempe&ntilde;o, entre otros).</big></li>\r\n<li><big>Intervenir sobre procesos organizacionales empleando metodolog&iacute;as de trabajo actualizadas.</big></li>\r\n<li><big>Dirigir las actividades de Recursos Humanos en el marco de la Ley: C&oacute;digo de Trabajo, Reglamento Interno, C&oacute;digo de &Eacute;tica y dem&aacute;s disposiciones legales de acuerdo al sector de ejercicio.</big></li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<hr>\r\n<h4><big><strong>Beneficios</strong></big></h4>\r\n<ul>\r\n<li>\r\n<p><big><strong>32 lecciones&nbsp;</strong>organizadas.</big></p>\r\n</li>\r\n<li>\r\n<p><big><strong>Clases grabadas&nbsp;</strong>en un 100% de la totalidad de las mismas en la modalidad virtual.</big></p>\r\n</li>\r\n<li>\r\n<p><big><strong>Recursos pr&aacute;cticos</strong>&nbsp;para aprender competencias y habilidades para dar en el &aacute;rea de recursos humanos.</big></p>\r\n</li>\r\n<li>\r\n<p><big>Acceso a nuestras<strong>&nbsp;plataformas profesionales&nbsp;</strong></big></p>\r\n</li>\r\n<li>\r\n<p><big>Proyectos guiados paso a paso con<strong>&nbsp;resultados profesionales.</strong></big></p>\r\n</li>\r\n<li>\r\n<p><big>Aprende en la<strong>&nbsp;modalidad virtual.</strong></big></p>\r\n</li>\r\n<li>\r\n<p><big><strong>Videos explicativos&nbsp;</strong>del curso cortos y sencillos de entender.</big></p>\r\n</li>\r\n<li>\r\n<p><big><strong>Explicaciones din&aacute;micas, claras y objetivas.</strong></big></p>\r\n</li>\r\n<li>\r\n<p><big>Soporte&nbsp;<strong>t&eacute;cnico 24/7.</strong></big></p>\r\n</li>\r\n<li>\r\n<p><big><strong>Relaci&oacute;n directa&nbsp;</strong>con personal docente y administrativo.&nbsp;</big></p>\r\n</li>\r\n<li>\r\n<p><big>Acceso al instructor para<strong>&nbsp;resolver dudas.</strong></big></p>\r\n</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<hr>\r\n<h3><big><strong>Modalidad</strong></big></h3>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>\r\n<p><big><strong>Virtual,&nbsp;</strong>por medio de la plataforma Zoom.</big></p>\r\n</li>\r\n</ul>', 'post_699f628a7f8ed2.39347201-talento.png', '2026-02-25 20:58:50', 1, 0, '', '', '', 0),
(47, 24, 'prueba', '123', '<p>123</p>', 'post_69a30d9d5eb203.31081030-2310.jpg', '2026-02-28 15:45:33', 6, 0, '', '', '', 0),
(48, 24, 'prueba 2', 'dfg', '<p>adfg</p>', 'post_69a30de2214315.48604482-2310.jpg', '2026-02-28 15:46:42', 6, 1, '', '', '', 0),
(50, 24, 'Prueba dipl', 'qwe', '<p>qwe</p>', 'post_69a30fd7495dd4.34160745-2310.jpg', '2026-02-28 15:55:03', 1, 0, '', '', '', 0),
(51, 24, 'Prueba', 'asd', '<p>asdf</p>', 'post_69a31073255209.19061091-2310.jpg', '2026-02-28 15:57:39', 1, 0, '', '', '', 0),
(52, 16, 'Auxiliar en Veterinaria', 'El programa otorga las competencias necesarias para dar apoyo al médico veterinario en procedimientos médicos y quirúrgicos.', '<p>El programa pretende formar estudiantes capaces de dar apoyo al m&eacute;dico veterinario en procedimientos m&eacute;dicos y quir&uacute;rgicos.&nbsp; Adem&aacute;s conocer los fundamentos de los cuidados de animales de compa&ntilde;&iacute;a y su comportamiento, atenci&oacute;n durante la consulta e<br>internamiento en animales con alguna patolog&iacute;a.</p>', '', '2026-02-28 17:37:40', 7, 0, '', '', '', 0),
(53, 16, 'Auxiliar en Farmacia', 'El programa Otorga las competencias necesarias para dar soporte al Farmacéutico y cumplir con las operaciones que se desarrollan en una farmacia comunitaria.', '<p>Adquirir&aacute;s conocimientos farmacol&oacute;gicos de los diferentes productos; podr&aacute;s asesorar con eficiencia a los clientes de acuerdo a sus necesidades. Adem&aacute;s de obtener conocimientos de despacho y almacenaje de las medicinas.</p>', '', '2026-02-28 17:50:20', 7, 0, '', '', '', 0),
(54, 16, 'Red de Cuido y Asistente de Pacientes', 'Adquiere conocimientos, habilidades y destrezas que te permita brindar una atención integral del paciente que lo necesite.', '<p>Otorga las competencias y habilidades id&oacute;neas para que el participante pueda formarse para un acompa&ntilde;amiento integral del&nbsp; paciente.</p>', '', '2026-02-28 17:59:20', 7, 0, '', '', '', 0),
(55, 16, 'Asistente Dental', 'El programa le brinda al participante las habilidades necesarias para asistir de forma efectiva a los profesionales de la salud en sus labores administrativas y complementarias del ambiente de la clínica.', '<p>El programa proporciona al estudiante aspectos generales de la odontolog&iacute;a y sus diferentes especialidades como la ortodoncia, as&iacute; mismo conoce generalidades y procedimientos relacionados con esta &aacute;rea de la salud. Este programa le brinda al participante las habilidades necesarias para asistir de forma efectiva a los profesionales de la salud en sus labores administrativas y complementarias del ambiente de la cl&iacute;nica.</p>', '', '2026-02-28 18:58:51', 7, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonios`
--

CREATE TABLE `testimonios` (
  `id_testimonio` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `profesion` varchar(255) DEFAULT NULL,
  `comentario` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `video_iframe` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `testimonios`
--

INSERT INTO `testimonios` (`id_testimonio`, `nombre`, `profesion`, `comentario`, `foto`, `created_at`, `video_iframe`) VALUES
(3, 'Renan Galvan', 'estudiante de diseño', 'comentario', '', '2026-02-28 15:08:46', '<iframe src=\"https://drive.google.com/file/d/0B31D5wJfU_a6bW8tQ0tISWN6Znc/preview?resourcekey=0-BepZZT_8QpWgBT1wvv5KtA\" width=\"640\" height=\"480\"></iframe>'),
(5, 'Alberto Garces', 'Estudiante', 'dgjsdgjadgj', '', '2026-02-28 16:51:29', '<iframe src=\"https://drive.google.com/file/d/0B31D5wJfU_a6bW8tQ0tISWN6Znc/preview?resourcekey=0-BepZZT_8QpWgBT1wvv5KtA\" width=\"640\" height=\"480\"></iframe>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin' COMMENT 'Rol del usuario: superadmin o admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `full_name`, `role`) VALUES
(1, 'renangalvan', '$2y$10$NZLnCv2pM2pM4OkzONw06.1kjIOaKfbW15/P2OsKxUYSc7.nj5Wmu', 'Renan Galvan', 'superadmin'),
(6, 'cburgos', '$2y$10$izN93bnqlW1WPTk5Hc3Fpet/ponROmw.sAF/BfysVuPUTT0gkDdd2', 'Carolina Burgos Badilla', 'admin'),
(7, 'galfaro', '$2y$10$xLt6Fi5HXa0FzUmqS8f1H.KzMo5Xx.trXNnd1H7vC/HmUJmmrV7ZS', 'Gustavo Alfaro Fonseca', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_frontend`
--

CREATE TABLE `users_frontend` (
  `id_user_frontend` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users_frontend`
--

INSERT INTO `users_frontend` (`id_user_frontend`, `username`, `full_name`, `password`, `email`, `created_at`) VALUES
(7, 'lorena', 'Lorena Galvan', '$2y$10$btHhIVhp.GVe/v4P7f200uIkhY3usA.X19aQXC3iYJVahYh3VE7Uq', 'lorena@gmail.com', '2025-07-26 17:22:01'),
(8, 'josegalvan', 'Jose Galvan', '$2y$10$5PP3ZhsmTCknhUFt4sWDNuCNwx2ODal3m3CPNrRinAJ1iZxOLKtOe', 'josegalvan@gmail.com', '2025-07-26 17:28:39'),
(9, 'jorgegalvan', 'Jorge Galvan', '$2y$10$dQb4hTf.BELyJSe9fitVSO8CnD8qL7tWSeH2r3gK09OJ.H5UWgoMK', 'jorgegalvan@gmail.com', '2025-07-26 17:36:49'),
(10, 'mariaprado', 'Maria Prado', '$2y$10$7jYE6eaTi82fh5ouJUYI.uiXNsj9GUZfqP3e5dnqaK/nSVH7ehtTa', 'mariaprado@gmail.com', '2025-07-30 20:02:07'),
(11, 'josias2025', 'Josias Betancur', '$2y$10$/HCYR4FoVXDJuy99iR8OXepabExgJnxxb2oVAnaf07mCkMfyPgZfu', 'josias2025@gmail.com', '2025-08-05 16:39:03'),
(12, 'manuelruiz', 'Manuel Ruiz', '$2y$10$aCpPSv/vvb/9JIbIxtphxuNoyyNAlXW2S1Ljmf2Kj/uattY.eRXse', 'manuelruiz@gmail.com', '2025-08-06 17:11:01'),
(13, 'joseo', 'José Miguel Obando Barquero', '$2y$10$vjclLfsnqUt9Ch.xlHEXVe9JrXigK8AKnhuoNWgIuUZGfqpD8vsGe', 'joseobando43@hotmail.com', '2025-08-11 23:15:59'),
(14, '0108780697', 'Luis Felipe Rodriguez Calderon', '$2y$10$cgUgXxvC7.riY6HNQfycq.wV.0Oa4FSyc3kAjacJkNYGHt6TaTIHC', 'feroca826@gmail.com', '2025-08-16 18:06:59'),
(15, 'caleb', 'Caleb Hernandez Chaves', '$2y$10$MnS.zu5bReg8m5iUPKsAOuIiae9w.Qr7r.cq7SYytLGRqxENPWPv.', 'caleb692001@gmail.com', '2025-08-19 19:25:12'),
(16, 'REIMER', 'ZAPATA', '$2y$10$Gtm9ruOcEEu5EHNxabz5..0xENENAnnhJntaD0UZr2zME1hcZiLk2', 'reimerdj@hotmail.com', '2025-08-20 14:53:55'),
(17, 'abdenago', 'Abdenago Piedra Murillo', '$2y$10$9LG5h.sJg6BlTFcznwFZSubeJl7yLrbH3TWfw77VQar15C6ZlGFOi', 'abdenagopiedram@hotmail.com', '2025-08-20 22:46:15'),
(18, 'Karla', 'Karla Judith Vado Peña', '$2y$10$Kf3f0AdDvpwYOro7GSjgOevJKfaoKFCNvUFLM3./LspwN6Y4WKdV6', 'Kvadopena@gmail.com', '2025-08-23 02:53:31'),
(19, 'LuisSalas2006', 'Luis Andrés Salas Centeno', '$2y$10$b.NgGvq8j5kILLTEUG3kEe86eg/eUeonFEbVEtdMJ5GOiCvs1j60e', 'andres.tito.1907@gmail.com', '2025-08-25 21:45:38'),
(20, 'Mau08', 'Mauricio Largaespada', '$2y$10$RstxF0UYXJkkek2Z.pAFKu5RwM5h18JHK0IzORqR9popVegE.KHOW', 'mlargaespadau@hotmail.com', '2025-08-29 04:55:42'),
(21, 'Alonsouned', 'Alonso', '$2y$10$YfyfJvSaei8okWJ4B7IiWe4FmRrSr6YvghE3Np.tFkxnYsAIpJ2Xm', 'alonso.uned@gmail.com', '2025-09-07 20:56:39'),
(22, 'CINDYGL', 'CINDY GUTIERREZ LEDEZMA', '$2y$10$7eGzh6PM3bzBAsB1KAt7e.jhWRwvx0N4.f685OFLtE9EaC6ivwLf6', 'licdacindygutierrezl@gmail.com', '2025-10-18 17:25:31'),
(23, 'gabriela.vargas.garro', 'Ana Gabriela Vargas Garro', '$2y$10$I2aWUJvLvsrECJS86PTnyevmZSgH75O1OnTr.Nk8jdMN/l7vGk6e6', 'ggar1411@gmail.com', '2025-10-21 22:40:22'),
(24, 'PabloG', 'Pablo César Gómez Montero', '$2y$10$FGh.Z7ZKh1a4PrBYpNfY3uaBCjxokAhfoAaQnfwmCCR2pfreReJe.', 'pcggomez7@gmail.com', '2025-10-26 22:03:49'),
(25, 'Diego', 'Diego calvo saenz', '$2y$10$jfaSDOTADVkwoHog2I63TeLpaSLRBBJxNNX4V1QnrP45agg01dSQ.', 'calvodiego422@gmail.com', '2025-10-27 22:41:06'),
(26, 'ds', 'fdsf', '$2y$10$EPsBSNTgzSHEIVFSDrAtMuaZ/MeNdmxeEvZhGqpWZCUouLeBpYWOi', 'renjazuexploit@gmail.com', '2025-11-07 15:09:01'),
(27, 'Arthur_K', 'José Alberto Bonilla Fonseca', '$2y$10$To6c0Qhy7Ckesijj69ixO.u16KBrDkWh2SodnDBQX76nmpVQXQK4O', 'josebonilla2389@gmail.com', '2025-11-13 00:20:28'),
(28, 'palvaradoluisal', 'LUIS ALBERTO PAREDES ALVARADO', '$2y$10$u5.sVm8qFiVA2XICOycIbOhVhjINEyZqXr25HfOhQHDzvoE9lE6XO', 'palvaradoluisal@gmail.com', '2025-11-14 00:36:57'),
(29, 'Diego123', 'DIEGO MONGE CHINCHILLA', '$2y$10$bie9WR7M3cbMEcDrrNIByuzMykRmm/aLWBhLW3OS69RyOwIwq6PGS', 'davidchinchilla23@gmail.com', '2025-11-15 18:48:05'),
(30, 'GASOLAN2026', 'ElizabethGarciaSolano', '$2y$10$c3sihCar03AqbC/2KnUUV.ROkZ386MBwp6yYDkH66ZmKuVKCem1Je', 'egasol40@yahoo.es', '2025-12-11 14:45:36'),
(31, 'lobi6261@gmail.com', 'Hbbd brahim', '$2y$10$2FakyscUoZHZUfUhoeUww.08uyYHBmthAW9KGNLx0PK612vpLnYL2', 'lobi6261@gmail.com', '2025-12-31 11:02:48'),
(32, 'leoncastro', 'Diego León', '$2y$10$URFFVTAtFfVgk.va3sCCHuqVttPmYlvnZJcp6gQIs1YsGpJhyK6fy', 'leoncastrodiego@gmail.com', '2026-01-13 00:22:55'),
(33, '602650673', 'Elizabeth Quiros Blanco', '$2y$10$1SQVh4IsMyJYHQKhxpDkx.WstSbpw2mWzEQSVLZJubNGGlvo2r/B2', 'eliquiros1975@gmail.com', '2026-01-13 20:31:32'),
(34, 'xenux', 'asdasd', '$2y$10$g7NiGW72.NBlv/iF8AjLhONVjNp8vI72mxRQo5YEOMhBfDhDFnIuG', 'adam@mail.com', '2026-01-15 13:49:38'),
(35, 'darteaga', 'Daulin Jose Arteaga Figueredo', '$2y$10$lu9Oxt1XDj45f.L7Id/m6OE3zV5gsByc9pi93LEJ/3C/TF1s1.bDS', 'daulin18@gmail.com', '2026-01-16 15:41:01'),
(36, 'gildadamasceno', 'Gilda Maria Damasceno', '$2y$10$PE4NSS3oHtv4Yt9qHEFQJexv24K9OsR780koZacDQc0.aAjY590/S', 'gildadamasceno@gmail.com', '2026-01-30 18:24:28'),
(37, 'josuekameko', 'Josue Rodriguez Alvarado', '$2y$10$heeANC5QSw/.R.bRnUKmROuubgpRuc3X3Jg.FyzstjZkoIkeiylZe', 'jfra.trabajo@gmail.com', '2026-02-22 06:38:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_modules`
--

CREATE TABLE `user_modules` (
  `id_user` int(11) NOT NULL,
  `id_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_modules`
--

INSERT INTO `user_modules` (`id_user`, `id_module`) VALUES
(1, 1),
(6, 1),
(7, 1),
(1, 2),
(6, 2),
(7, 2),
(1, 3),
(6, 3),
(7, 3),
(1, 4),
(6, 4),
(7, 4),
(1, 5),
(6, 5),
(7, 5),
(1, 6),
(6, 6),
(7, 6),
(1, 7),
(6, 7),
(7, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id_attachment`),
  ADD KEY `id_post` (`id_post`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `datos_cliente`
--
ALTER TABLE `datos_cliente`
  ADD PRIMARY KEY (`id_cliente_data`);

--
-- Indices de la tabla `formulario_matricula`
--
ALTER TABLE `formulario_matricula`
  ADD PRIMARY KEY (`id_matricula`);

--
-- Indices de la tabla `graduaciones`
--
ALTER TABLE `graduaciones`
  ADD PRIMARY KEY (`id_graduacion`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `graduaciones_attachments`
--
ALTER TABLE `graduaciones_attachments`
  ADD PRIMARY KEY (`id_attachment`),
  ADD KEY `id_graduacion` (`id_graduacion`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `menus_ibfk_1` (`parent_id`);

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id_module`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `posts_ibfk_2` (`id_user`);

--
-- Indices de la tabla `testimonios`
--
ALTER TABLE `testimonios`
  ADD PRIMARY KEY (`id_testimonio`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `users_frontend`
--
ALTER TABLE `users_frontend`
  ADD PRIMARY KEY (`id_user_frontend`);

--
-- Indices de la tabla `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`id_user`,`id_module`),
  ADD KEY `fk_user_modules_module` (`id_module`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id_attachment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `datos_cliente`
--
ALTER TABLE `datos_cliente`
  MODIFY `id_cliente_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `formulario_matricula`
--
ALTER TABLE `formulario_matricula`
  MODIFY `id_matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `graduaciones`
--
ALTER TABLE `graduaciones`
  MODIFY `id_graduacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `graduaciones_attachments`
--
ALTER TABLE `graduaciones_attachments`
  MODIFY `id_attachment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `testimonios`
--
ALTER TABLE `testimonios`
  MODIFY `id_testimonio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users_frontend`
--
ALTER TABLE `users_frontend`
  MODIFY `id_user_frontend` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE;

--
-- Filtros para la tabla `graduaciones`
--
ALTER TABLE `graduaciones`
  ADD CONSTRAINT `graduaciones_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Filtros para la tabla `graduaciones_attachments`
--
ALTER TABLE `graduaciones_attachments`
  ADD CONSTRAINT `graduaciones_attachments_ibfk_1` FOREIGN KEY (`id_graduacion`) REFERENCES `graduaciones` (`id_graduacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_modules`
--
ALTER TABLE `user_modules`
  ADD CONSTRAINT `fk_user_modules_module` FOREIGN KEY (`id_module`) REFERENCES `modules` (`id_module`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_modules_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
