-- RecipeHub auth schema
CREATE DATABASE IF NOT EXISTS recipehub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE recipehub;
CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- seed admin (admin123)
INSERT INTO users (name,email,password,role) VALUES ('Admin','admin@recipehub.local','$2y$10$8zqZ9DgrVnJbYzM2p8MiUO7Vv9m9t0l0jXx3gB6mX6p4y7m5wq2ba','admin')
ON DUPLICATE KEY UPDATE email = email;
