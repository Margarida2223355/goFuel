-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 12-Out-2024 às 18:14
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
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, NULL, NULL, NULL, 1728426325, 1728426325),
('Client', 1, NULL, NULL, NULL, 1728426325, 1728426325),
('Employee', 1, NULL, NULL, NULL, 1728426325, 1728426325),
('In Charge', 1, NULL, NULL, NULL, 1728426325, 1728426325),
('Manager', 1, NULL, NULL, NULL, 1728426325, 1728426325);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Employee', 'Client'),
('In Charge', 'Employee'),
('Manager', 'In Charge'),
('Admin', 'Manager');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
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
  `state_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoice_lines`
--

CREATE TABLE `invoice_lines` (
  `id` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `pump_id` int DEFAULT NULL,
  `qty` int NOT NULL,
  `total` double NOT NULL,
  `invoice_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoice_states`
--

CREATE TABLE `invoice_states` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(6, 6, 500),
(7, 7, 100),
(8, 8, 50);

-- --------------------------------------------------------

--
-- Estrutura da tabela `manager_station`
--

CREATE TABLE `manager_station` (
  `manager_id` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('m000000_000000_base', 1728753751),
('m130524_201442_init', 1728753757),
('m140506_102106_rbac_init', 1728753753),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1728753753),
('m180523_151638_rbac_updates_indexes_without_prefix', 1728753753),
('m190124_110200_add_verification_token_column_to_user_table', 1728753757),
('m200409_110543_rbac_update_mssql_trigger', 1728753753),
('m241008_222306_init_rbac_roles', 1728753757);

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
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `stations`
--

CREATE TABLE `stations` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `manager_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `stations`
--

INSERT INTO `stations` (`id`, `name`, `address`, `postal_code`, `manager_id`) VALUES
(1, 'Station 1', '123 Main St', '1000-001', NULL),
(2, 'Station 2', '456 Market Ave', '1000-002', NULL),
(4, 'Test Station', 'Rua de Teste', '2365-875', 2),
(5, 'Station 3', 'Rua de Testsse', '2365-875', 2),
(6, 'Station Sei lá', 'Rua de Test', '2365-875', 2);

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
(3, 4, 5, 1.3),
(4, 5, 4, 1),
(5, 5, 3, 1),
(7, 5, 3, 0.6);

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
(2, 5),
(2, 6);

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_info`
--

CREATE TABLE `user_info` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nif` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `station_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `nif`, `name`, `address`, `postal_code`, `phone`, `station_id`) VALUES
(1, 1, 123456789, 'Admin User', 'Rua Admin 1', '1000-001', '123456789', NULL),
(2, 2, 987654321, 'Manager User', 'Rua Manager 2', '1000-002', '987654321', NULL),
(3, 3, 123789456, 'In Charge User', 'Rua In Charge 3', '1000-003', '123789456', NULL),
(4, 4, 456123789, 'Employee User', 'Rua Employee 4', '1000-004', '456123789', NULL),
(5, 5, 789456123, 'Client User', 'Rua Client 5', '1000-005', '789456123', NULL),
(6, 6, 965412387, 'David Afonso Domingues', 'Rua Centro de Acolhimento', '3280-113', '965874222', NULL);

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
  ADD KEY `fk_invoicelines_items` (`item_id`),
  ADD KEY `fk_invoicelines_pumps` (`pump_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_manager_id_idx` (`manager_id`);

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
  ADD UNIQUE KEY `nif_UNIQUE` (`nif`),
  ADD KEY `fk_user_info_user_id` (`user_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `invoice_lines`
--
ALTER TABLE `invoice_lines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `invoice_states`
--
ALTER TABLE `invoice_states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `station_items`
--
ALTER TABLE `station_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
-- Limitadores para a tabela `invoice_lines`
--
ALTER TABLE `invoice_lines`
  ADD CONSTRAINT `fk_invoicelines_items` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_invoicelines_pumps` FOREIGN KEY (`pump_id`) REFERENCES `pumps` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Limitadores para a tabela `manager_station`
--
ALTER TABLE `manager_station`
  ADD CONSTRAINT `manager_station_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `manager_station_ibfk_2` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `fk_manager_id` FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `station_items`
--
ALTER TABLE `station_items`
  ADD CONSTRAINT `fk_station_items_item_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `fk_station_items_station_id` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`);

--
-- Limitadores para a tabela `station_users`
--
ALTER TABLE `station_users`
  ADD CONSTRAINT `station_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
