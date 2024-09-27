-- Active: 1727279290726@@127.0.0.1@3306
CREATE DATABASE gofuel DEFAULT CHARACTER SET = 'utf8mb4';

USE gofuel;

-- Criar tabela de categorias (independente de outras tabelas)
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
) ENGINE = InnoDB;

-- Criar tabela de estações (independente de outras tabelas)
CREATE TABLE stations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL
) ENGINE = InnoDB;

-- Criar tabela de combustíveis (independente de outras tabelas)
CREATE TABLE fuels (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM('normal', 'additive') NOT NULL,
    price DOUBLE NOT NULL
) ENGINE = InnoDB;

-- Criar tabela de faturas (invoices) (depende de user, mas criada antes de invoice_lines)
CREATE TABLE invoices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    invoice_date DATE NOT NULL,
    total DOUBLE NOT NULL,
    FOREIGN KEY (client_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de linhas da fatura (depende de invoices)
CREATE TABLE invoice_lines (
    id INT PRIMARY KEY AUTO_INCREMENT,
    unit_price DOUBLE NOT NULL,
    qty INT NOT NULL,
    total DOUBLE NOT NULL,
    invoice_id INT NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de itens (depende de categories)
CREATE TABLE items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    price DOUBLE NOT NULL,
    qty INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de bombas (pumps) (depende de stations)
CREATE TABLE pumps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    station_id INT NOT NULL,
    FOREIGN KEY (station_id) REFERENCES stations (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de relacionamento fuel_pump (depende de fuels e pumps)
CREATE TABLE fuel_pump (
    fuel_id INT,
    pump_id INT,
    PRIMARY KEY (fuel_id, pump_id),
    FOREIGN KEY (fuel_id) REFERENCES fuels (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pump_id) REFERENCES pumps (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de relacionamento station_item (depende de stations e items)
CREATE TABLE station_item (
    station_id INT,
    item_id INT,
    PRIMARY KEY (station_id, item_id),
    FOREIGN KEY (station_id) REFERENCES stations (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de relacionamento fuel_invoice_line (depende de fuels e invoice_lines)
CREATE TABLE fuel_invoice_line (
    fuel_id INT,
    invoice_line_id INT,
    PRIMARY KEY (fuel_id, invoice_line_id),
    FOREIGN KEY (fuel_id) REFERENCES fuels (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (invoice_line_id) REFERENCES invoice_lines (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de relacionamento item_invoice_line (depende de items e invoice_lines)
CREATE TABLE item_invoice_line (
    item_id INT,
    invoice_line_id INT,
    PRIMARY KEY (item_id, invoice_line_id),
    FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (invoice_line_id) REFERENCES invoice_lines (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Criar tabela de user_info (depende de user do framework)
CREATE TABLE user_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM(
        'admin',
        'manager',
        'incharge',
        'employee'
    ) NOT NULL,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;