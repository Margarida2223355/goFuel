-- Active: 1727279290726@@127.0.0.1@3306
# CREATE DATABASE gofuel DEFAULT CHARACTER SET = 'utf8mb4';

USE gofuel;

-- Criação da tabela user_info
CREATE TABLE user_info (
    id INTEGER PRIMARY KEY,
    user_id INTEGER, -- Referência para o id da tabela default do Yii2 Framework
    nif INTEGER,
    role ENUM(
        'Admin',
        'Manager',
        'In Charge',
        'Employee'
    ),
    email VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255),
    postal_code VARCHAR(20),
    CONSTRAINT fk_user_info_user_id FOREIGN KEY (user_id) REFERENCES default_user (id) -- Referência à tabela padrão de usuários do Yii2
);

-- Criação da tabela items
CREATE TABLE items (
    id INTEGER PRIMARY KEY,
    description VARCHAR(255),
    price DOUBLE,
    subcategory_id INTEGER,
    CONSTRAINT fk_items_subcategory_id FOREIGN KEY (subcategory_id) REFERENCES subcategories (id)
);

-- Criação da tabela categories
CREATE TABLE categories (
    id INTEGER PRIMARY KEY,
    name VARCHAR(255)
);

-- Criação da tabela subcategories
CREATE TABLE subcategories (
    id INTEGER PRIMARY KEY,
    description VARCHAR(255),
    category_id INTEGER,
    CONSTRAINT fk_subcategories_category_id FOREIGN KEY (category_id) REFERENCES categories (id)
);

-- Criação da tabela item_stocks
CREATE TABLE item_stocks (
    id INTEGER PRIMARY KEY,
    item_id INTEGER,
    restock_qty INTEGER,
    CONSTRAINT fk_item_stocks_item_id FOREIGN KEY (item_id) REFERENCES items (id)
);

-- Criação da tabela stations
CREATE TABLE stations (
    id INTEGER PRIMARY KEY,
    name VARCHAR(255),
    address VARCHAR(255),
    postal_code VARCHAR(20)
);

-- Criação da tabela pumps
CREATE TABLE pumps (
    id INTEGER PRIMARY KEY,
    station_id INTEGER,
    CONSTRAINT fk_pumps_station_id FOREIGN KEY (station_id) REFERENCES stations (id)
);

-- Criação da tabela invoice_lines
CREATE TABLE invoice_lines (
    id INTEGER PRIMARY KEY,
    unit_price DOUBLE,
    qty INTEGER,
    total DOUBLE,
    invoice_id INTEGER,
    CONSTRAINT fk_invoice_lines_invoice_id FOREIGN KEY (invoice_id) REFERENCES invoices (id)
);

-- Criação da tabela invoices
CREATE TABLE invoices (
    id INTEGER PRIMARY KEY,
    client_id INTEGER,
    station_id INTEGER,
    invoice_date DATE,
    total DOUBLE,
    state_id INTEGER,
    CONSTRAINT fk_invoices_client_id FOREIGN KEY (client_id) REFERENCES user_info (id),
    CONSTRAINT fk_invoices_station_id FOREIGN KEY (station_id) REFERENCES stations (id),
    CONSTRAINT fk_invoices_state_id FOREIGN KEY (state_id) REFERENCES invoice_states (id)
);

-- Criação da tabela invoice_states
CREATE TABLE invoice_states (
    id INTEGER PRIMARY KEY,
    description VARCHAR(255) -- Descrição do estado (ex: 'Cart', 'Paid', 'Finish')
);