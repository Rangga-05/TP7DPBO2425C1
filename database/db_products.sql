CREATE DATABASE db_product;
USE db_product;

CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE,
    supplier_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    order_date DATE NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO suppliers (name, email, phone) VALUES
('PT Abadi Jaya', 'abadi@mail.com', '0811112222'),
('CV Sejahtera', 'sejahtera@mail.com', '0833334444');

INSERT INTO products (name, code, supplier_id, price, stock) VALUES
('Mouse Wireless X1', 'MWX-001', 1, 150000.00, 25),
('Keyboard Gaming K5', 'KGK-005', 1, 450000.00, 10),
('Monitor LED 24 inch', 'MLD-024', 2, 1800000.00, 5);