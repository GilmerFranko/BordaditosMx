-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2026 a las 19:44:08
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ryctv_bordamex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `action_description` text DEFAULT NULL,
  `timestamp` varchar(12) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color_variants`
--

CREATE TABLE `color_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_name` varchar(50) DEFAULT NULL,
  `image` varchar(128) NOT NULL,
  `size_available` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `image_section` varchar(256) DEFAULT NULL COMMENT 'Imagen principal del Section Hero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` tinyint(2) UNSIGNED NOT NULL DEFAULT 3,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `birthday` date NOT NULL DEFAULT '2000-01-01',
  `ip_address` varchar(46) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `banned` int(10) NOT NULL DEFAULT 0 COMMENT 'Fecha de suspensión',
  `banned_reason` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Razon de baneado',
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `last_login` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Último login',
  `notifications` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `session` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pp_timezone` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Europe/Madrid' COMMENT 'Zona horaria del Usuario',
  `pp_full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pp_main_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pp_thumb_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pp_photo_type` tinyint(1) NOT NULL DEFAULT 2,
  `pp_setting_preferences` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pp_gender` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Sexo (0 hombre, 1 mujer)',
  `pp_joined` int(10) NOT NULL DEFAULT 0 COMMENT 'Fecha de registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_blocks`
--

CREATE TABLE `members_blocks` (
  `block_id` int(11) NOT NULL,
  `block_from` int(11) NOT NULL,
  `block_to` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_groups`
--

CREATE TABLE `members_groups` (
  `g_id` int(3) UNSIGNED NOT NULL,
  `g_title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `g_colour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `g_permissions` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `g_max_messages` int(5) UNSIGNED DEFAULT 50,
  `g_max_shout_images` tinyint(2) UNSIGNED NOT NULL,
  `g_count_permissions` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `g_count_members` mediumint(8) UNSIGNED NOT NULL,
  `g_updated` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_messages`
--

CREATE TABLE `members_messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `from_member_id` int(11) UNSIGNED NOT NULL,
  `to_member_id` int(11) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `sent_at` varchar(12) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0 COMMENT '0: No leído, 1: Leído'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_notifications`
--

CREATE TABLE `members_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID de notificación',
  `to_member` mediumint(8) UNSIGNED NOT NULL COMMENT 'Usuario que recibe la notificación',
  `from_member` mediumint(8) UNSIGNED NOT NULL COMMENT 'Usuario que envía la notificación',
  `not_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo de notificación',
  `item_id` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `subitem_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_time` int(11) UNSIGNED NOT NULL,
  `read_time` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notificaciones de usuario';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_whatsapp` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_state` varchar(50) DEFAULT NULL,
  `shipping_city` varchar(50) DEFAULT NULL,
  `shipping_method` enum('DHL','Estafeta') DEFAULT NULL,
  `payment_method` enum('Card','OXXO','Transfer') DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL,
  `order_status` enum('Pending','Paid','Shipped','Delivered') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variant_id` varchar(50) DEFAULT NULL,
  `size_hoodie_1` varchar(20) DEFAULT NULL,
  `size_hoodie_2` varchar(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price_at_purchase` int(11) NOT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  `original_price` int(11) DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_configuration`
--

CREATE TABLE `site_configuration` (
  `id` int(11) NOT NULL,
  `script_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_abbreviation` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Abreviación del nombre del script',
  `ad_300x250` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookie_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookie_time` smallint(5) NOT NULL,
  `enable_email_on_message` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 para habilitar, 0 para deshabilitar el envío de correos cuando se recibe un mensaje',
  `card_pay_link` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Link de pago para targetas',
  `commission_per_bet` decimal(20,2) NOT NULL DEFAULT 0.50 COMMENT 'Comision cobrada a cada usuario por \r\napuesta',
  `limit_globals_messages` int(11) NOT NULL DEFAULT 100 COMMENT 'Limite de mensajes que se mostraran en un canal',
  `reg_group` int(11) NOT NULL DEFAULT 3,
  `reg_validate` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `maintenance` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `debug_mode` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `save_user` mediumint(8) NOT NULL,
  `save_ip` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `save_date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_contacts`
--

CREATE TABLE `site_contacts` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `member_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` int(10) UNSIGNED NOT NULL,
  `ip` varchar(46) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_recovers`
--

CREATE TABLE `site_recovers` (
  `id` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0 COMMENT '2 validación, 1 contraseña',
  `ip_address` varchar(46) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `top_products`
--

CREATE TABLE `top_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `position` int(2) NOT NULL COMMENT 'Posición en el Top 20',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variants_images`
--

CREATE TABLE `variants_images` (
  `id` int(11) NOT NULL,
  `color_variant_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_image` int(1) DEFAULT 0,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indices de la tabla `color_variants`
--
ALTER TABLE `color_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `name` (`name`),
  ADD KEY `mgroup` (`group_id`,`member_id`),
  ADD KEY `member_banned` (`banned`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `session` (`session`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `members_blocks`
--
ALTER TABLE `members_blocks`
  ADD PRIMARY KEY (`block_id`),
  ADD UNIQUE KEY `unique_block` (`block_from`,`block_to`);

--
-- Indices de la tabla `members_groups`
--
ALTER TABLE `members_groups`
  ADD PRIMARY KEY (`g_id`),
  ADD KEY `g_id` (`g_id`);

--
-- Indices de la tabla `members_messages`
--
ALTER TABLE `members_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_member_id` (`from_member_id`),
  ADD KEY `to_member_id` (`to_member_id`);

--
-- Indices de la tabla `members_notifications`
--
ALTER TABLE `members_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `not_key` (`not_key`),
  ADD KEY `from_member` (`from_member`),
  ADD KEY `to_member` (`to_member`),
  ADD KEY `sent_time` (`sent_time`,`read_time`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `site_configuration`
--
ALTER TABLE `site_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `site_contacts`
--
ALTER TABLE `site_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `site_recovers`
--
ALTER TABLE `site_recovers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `email` (`email`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `top_products`
--
ALTER TABLE `top_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `variants_images`
--
ALTER TABLE `variants_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`color_variant_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `color_variants`
--
ALTER TABLE `color_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members_blocks`
--
ALTER TABLE `members_blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members_groups`
--
ALTER TABLE `members_groups`
  MODIFY `g_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members_messages`
--
ALTER TABLE `members_messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members_notifications`
--
ALTER TABLE `members_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de notificación';

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `site_configuration`
--
ALTER TABLE `site_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `site_contacts`
--
ALTER TABLE `site_contacts`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `top_products`
--
ALTER TABLE `top_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `variants_images`
--
ALTER TABLE `variants_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `color_variants`
--
ALTER TABLE `color_variants`
  ADD CONSTRAINT `color_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `top_products`
--
ALTER TABLE `top_products`
  ADD CONSTRAINT `top_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
