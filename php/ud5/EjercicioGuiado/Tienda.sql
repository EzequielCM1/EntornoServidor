DROP DATABASE IF EXISTS tienda;
CREATE DATABASE tienda;
USE tienda;
CREATE TABLE usuarios (
   id INT AUTO_INCREMENT PRIMARY KEY,
   usuario VARCHAR(30) UNIQUE NOT NULL,
   password VARCHAR(100) NOT NULL,
   rol ENUM ('admin','usuario','invitado') DEFAULT 'usuario',
   ultimo_acceso TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE categoria (
   id_categoria INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30) NOT NULL,
   descripcion VARCHAR(100)
);
CREATE TABLE productos (
   id_producto INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30) NOT NULL,
   descripcion VARCHAR(100),
   precio FLOAT NOT NULL,
   id_categoria INT NULL,
   fecha_creacion DATE NULL,
   FOREIGN KEY (id_categoria) REFERENCES categoria (id_categoria)
);

INSERT INTO `tienda`.`usuarios` (`usuario`, `password`) VALUES ('ezequiel', '$2y$10$gtU.pMSyfEbEm5dwaszZ9Ob7x7uqyALzCuFyHtbkLJ1A9SoJt0cai');
UPDATE `tienda`.`usuarios` SET `rol` = 'admin' WHERE (`id` = '1');


-- Crear el usuario de la aplicación
CREATE USER IF NOT EXISTS 'usuario_tienda'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON tienda.* TO 'usuario_tienda'@'localhost';
FLUSH PRIVILEGES;
-- SHOW GRANTS FOR 'usuario_tienda'@'localhost'; esto es para comprobar si tiene acceso si sale usage es que no
-- DROP USER IF EXISTS 'usuario_tienda'@'localhost';
-- SELECT User, Host FROM mysql.user;

