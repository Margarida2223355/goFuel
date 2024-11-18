-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 14-Out-2024 às 20:20
-- Versão do servidor: 8.0.35
-- versão do PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gofuel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '1', 1728772371);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, NULL, NULL, NULL, 1728772371, 1728772371),
('Client', 1, NULL, NULL, NULL, 1728772371, 1728772371),
('Employee', 1, NULL, NULL, NULL, 1728772371, 1728772371),
('In Charge', 1, NULL, NULL, NULL, 1728772371, 1728772371),
('Manager', 1, NULL, NULL, NULL, 1728772371, 1728772371);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Gasoline'),
(2, 'Diesel'),
(3, 'Snacks'),
(4, 'Accessories'),
(5, 'Tobacco');

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `station_id` int NOT NULL,
  `invoice_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` double NOT NULL,
  `state_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `invoices`
--

INSERT INTO `invoices` (`id`, `client_id`, `station_id`, `invoice_date`, `total`, `state_id`) VALUES
(1, 1, 1, '2024-10-13 01:15:40', 100, 1),
(2, 1, 1, '2024-10-13 01:15:40', 150.5, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoice_lines`
--

CREATE TABLE `invoice_lines` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `qty` int NOT NULL,
  `total` double NOT NULL,
  `invoice_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `invoice_lines`
--

INSERT INTO `invoice_lines` (`id`, `item_id`, `qty`, `total`, `invoice_id`) VALUES
(1, 1, 10, 100, 1),
(2, 2, 5, 50, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoice_states`
--

CREATE TABLE `invoice_states` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `invoice_states`
--

INSERT INTO `invoice_states` (`id`, `description`) VALUES
(1, 'Paid'),
(2, 'Pending'),
(3, 'Cancelled');

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE `items` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `subcategory_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `description`, `subcategory_id`) VALUES
(1, 'Unleaded 95 - 1L', 1),
(2, 'Unleaded 98 - 1L', 2),
(3, 'Diesel Regular - 1L', 3),
(4, 'Diesel Premium - 1L', 4),
(5, 'Pack of Chips', 5),
(8, 'Car Charger', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_stocks`
--

CREATE TABLE `item_stocks` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `restock_qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `item_stocks`
--

INSERT INTO `item_stocks` (`id`, `item_id`, `restock_qty`) VALUES
(1, 1, 5000),
(2, 2, 3000),
(3, 3, 7000),
(4, 4, 4000),
(5, 5, 200),
(8, 8, 50);

-- --------------------------------------------------------

--
-- Estrutura da tabela `manager_station`
--

CREATE TABLE `manager_station` (
  `manager_id` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `manager_station`
--

INSERT INTO `manager_station` (`manager_id`, `station_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1728772351),
('m130524_201442_init', 1728772370),
('m140506_102106_rbac_init', 1728772352),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1728772352),
('m180523_151638_rbac_updates_indexes_without_prefix', 1728772352),
('m190124_110200_add_verification_token_column_to_user_table', 1728772370),
('m200409_110543_rbac_update_mssql_trigger', 1728772352),
('m241008_222306_init_rbac_roles', 1728772371);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pumps`
--

CREATE TABLE `pumps` (
  `id` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pumps`
--

INSERT INTO `pumps` (`id`, `station_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `stations`
--

CREATE TABLE `stations` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `stations`
--

INSERT INTO `stations` (`id`, `name`, `address`, `postal_code`) VALUES
(1, 'Station 1', '123 Main St', '1000-001'),
(2, 'Station 2', '456 Side St', '1000-002');

-- --------------------------------------------------------

--
-- Estrutura da tabela `station_items`
--

CREATE TABLE `station_items` (
  `id` int NOT NULL,
  `station_id` int NOT NULL,
  `item_id` int NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `station_items`
--

INSERT INTO `station_items` (`id`, `station_id`, `item_id`, `price`) VALUES
(1, 1, 1, 1.3),
(2, 1, 2, 1.5),
(3, 1, 3, 0.9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `station_users`
--

CREATE TABLE `station_users` (
  `user_id` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `station_users`
--

INSERT INTO `station_users` (`user_id`, `station_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `subcategories`
--

INSERT INTO `subcategories` (`id`, `description`, `category_id`) VALUES
(1, 'Unleaded 95', 1),
(2, 'Unleaded 98', 1),
(3, 'Diesel Regular', 2),
(4, 'Diesel Premium', 2),
(5, 'Chips', 3),
(6, 'Soda', 3),
(7, 'Car Fresheners', 4),
(8, 'Car Chargers', 4),
(9, 'Conventional Tobacco', 5),
(10, 'Heated Tobacco', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'maggie', 'ly3HCuu1ziaGYHJL_nlsxFk2zSMxYRcO', '$2y$13$70M8kNNfdoLyYnjfTAd/qOyGCgYainv1/WtBUrKO3fJnhUSJS4TS6', NULL, 'maggie@a.com', 10, 1728778036, 1728778036, 'F0JwBkJ56BmPFZNb2hcCk5UXBgLwviN3_1728778036'),
(2, 'client1', 'exampleAuthKey2', '$2y$10$exampleHashedPassword2', NULL, 'client1@example.com', 10, 1728778339, 1728778339, 'exampleVerificationToken2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_info`
--

CREATE TABLE `user_info` (
  `id` int NOT NULL,
  `nif` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `user_info`
--

INSERT INTO `user_info` (`id`, `nif`, `name`, `address`, `postal_code`, `phone`) VALUES
(1, 9999999, 'Margarida', 'Rua Direita', '9999-999', '99999999'),
(2, 987654321, 'Jane Smith', '2nd Avenue', '1000-002', '987654321');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Índices para tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Índices para tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Índices para tabela `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_client_id` (`client_id`),
  ADD KEY `fk_invoices_station_id` (`station_id`),
  ADD KEY `fk_invoices_state_id` (`state_id`);

--
-- Índices para tabela `invoice_lines`
--
ALTER TABLE `invoice_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_lines_invoice_id` (`invoice_id`),
  ADD KEY `fk_invoices_items` (`item_id`);

--
-- Índices para tabela `invoice_states`
--
ALTER TABLE `invoice_states`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_subcategory_id_idx` (`subcategory_id`);

--
-- Índices para tabela `item_stocks`
--
ALTER TABLE `item_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_stocks_item_id` (`item_id`);

--
-- Índices para tabela `manager_station`
--
ALTER TABLE `manager_station`
  ADD PRIMARY KEY (`manager_id`,`station_id`),
  ADD KEY `station_id` (`station_id`);

--
-- Índices para tabela `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Índices para tabela `pumps`
--
ALTER TABLE `pumps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pumps_station_id` (`station_id`);

--
-- Índices para tabela `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `station_items`
--
ALTER TABLE `station_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_station_items_station_id_idx` (`station_id`),
  ADD KEY `fk_station_items_item_id_idx` (`item_id`);

--
-- Índices para tabela `station_users`
--
ALTER TABLE `station_users`
  ADD PRIMARY KEY (`user_id`,`station_id`),
  ADD KEY `station_id` (`station_id`);

--
-- Índices para tabela `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategories_category_id` (`category_id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Índices para tabela `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nif_UNIQUE` (`nif`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `invoice_lines`
--
ALTER TABLE `invoice_lines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `invoice_states`
--
ALTER TABLE `invoice_states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `items`
--
ALTER TABLE `items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `item_stocks`
--
ALTER TABLE `item_stocks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pumps`
--
ALTER TABLE `pumps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `station_items`
--
ALTER TABLE `station_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_invoicestates` FOREIGN KEY (`state_id`) REFERENCES `invoice_states` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_invoices_stations` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_invoices_userinfos` FOREIGN KEY (`client_id`) REFERENCES `user_info` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `invoice_lines`
--
ALTER TABLE `invoice_lines`
  ADD CONSTRAINT `fk_invoicelines_invoces` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_invoices_items` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Limitadores para a tabela `item_stocks`
--
ALTER TABLE `item_stocks`
  ADD CONSTRAINT `fk_itemstocks_items` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `manager_station`
--
ALTER TABLE `manager_station`
  ADD CONSTRAINT `fk_manager` FOREIGN KEY (`manager_id`) REFERENCES `user_info` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `pumps`
--
ALTER TABLE `pumps`
  ADD CONSTRAINT `fk_pumps_stations` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `station_items`
--
ALTER TABLE `station_items`
  ADD CONSTRAINT `fk_items` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_stations` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `station_users`
--
ALTER TABLE `station_users`
  ADD CONSTRAINT `station_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `station_users_ibfk_2` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Limitadores para a tabela `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `fk_userinfo_user` FOREIGN KEY (`id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
