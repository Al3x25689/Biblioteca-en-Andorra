CREATE DATABASE IF NOT EXISTS biblioteca;
USE biblioteca;
CREATE TABLE libros (id INT AUTO_INCREMENT PRIMARY KEY, titulo VARCHAR(255));
INSERT INTO libros (titulo) VALUES ('Libro ejemplo');
