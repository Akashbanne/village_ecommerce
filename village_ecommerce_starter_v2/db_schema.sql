-- Database schema for village_ecommerce (v2)
CREATE DATABASE IF NOT EXISTS village_ecommerce;
USE village_ecommerce;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  phone VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image VARCHAR(255) DEFAULT 'placeholder.png',
  stock INT DEFAULT 0,
  category VARCHAR(100),
  description TEXT
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  user_name VARCHAR(255),
  user_phone VARCHAR(50),
  user_address TEXT,
  total_amount DECIMAL(10,2) DEFAULT 0,
  status VARCHAR(50),
  created_at DATETIME
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- sample products
INSERT INTO products (name, price, stock, category, description) VALUES
('Fresh Potatoes (1kg)', 40.00, 100, 'Vegetables', 'Local farm potatoes'),
('Rice 5kg', 250.00, 50, 'Grocery', 'Staple rice'),
('Packaged Milk 1L', 50.00, 200, 'Dairy', 'Long life milk pack');
