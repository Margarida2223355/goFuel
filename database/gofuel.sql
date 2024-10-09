USE gofuel;

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `invoice_lines`;

CREATE TABLE `invoice_lines` (
    `id` int NOT NULL AUTO_INCREMENT,
    `qty` int NOT NULL,
    `total` double NOT NULL,
    `invoice_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_invoice_lines_invoice_id` (`invoice_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `invoice_states`;

CREATE TABLE `invoice_states` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
    `id` int NOT NULL AUTO_INCREMENT,
    `client_id` int NOT NULL,
    `station_id` int NOT NULL,
    `invoice_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total` double NOT NULL,
    `state_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_invoices_client_id` (`client_id`),
    KEY `fk_invoices_station_id` (`station_id`),
    KEY `fk_invoices_state_id` (`state_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `item_stocks`;

CREATE TABLE `item_stocks` (
    `id` int NOT NULL AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `restock_qty` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_item_stocks_item_id` (`item_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `subcategories`;

CREATE TABLE `subcategories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    `category_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_subcategories_category_id` (`category_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    `price` double NOT NULL,
    `subcategory_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_items_subcategory_id_idx` (`subcategory_id`),
    CONSTRAINT `fk_items_subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `pumps`;

CREATE TABLE `pumps` (
    `id` int NOT NULL AUTO_INCREMENT,
    `station_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_pumps_station_id` (`station_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `nif` int NOT NULL,
    `role` enum(
        'Admin',
        'Manager',
        'In Charge',
        'Employee'
    ) NOT NULL,
    `name` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `postal_code` varchar(20) NOT NULL,
    `phone` varchar(13) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nif_UNIQUE` (`nif`),
    KEY `fk_user_info_user_id` (`user_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `stations`;

CREATE TABLE `stations` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `postal_code` varchar(20) NOT NULL,
    `manager_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_manager_id_idx` (`manager_id`),
    CONSTRAINT `fk_manager_id` FOREIGN KEY (`manager_id`) REFERENCES `user_info` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `station_items`;

CREATE TABLE `station_items` (
    `id` int NOT NULL AUTO_INCREMENT,
    `station_id` int NOT NULL,
    `item_id` int NOT NULL,
    `price` double NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_station_items_station_id_idx` (`station_id`),
    KEY `fk_station_items_item_id_idx` (`item_id`),
    CONSTRAINT `fk_station_items_item_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_station_items_station_id` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;