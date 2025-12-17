-- 1. CREACIÓN DE LA BASE DE DATOS
DROP DATABASE IF EXISTS examen_dwes_3;
CREATE DATABASE IF NOT EXISTS examen_dwes_3;
-- la marcamos como activa
USE examen_dwes_3;

-- 2. CREACIÓN DE LA TABLA 'usuarios'
-- Esta tabla se utiliza para el login. La contraseña se almacena con hash (MD5 en este ejemplo).
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre_completo` VARCHAR(100) NOT NULL,
    `usuario` VARCHAR(20) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL COMMENT 'Contraseña hasheada',
    `rol` ENUM('admin','user') NOT NULL DEFAULT 'user',
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ;

-- 3. INSERCIÓN DE USUARIOS DE EJEMPLO
-- Se insertan dos usuarios de ejemplo.
-- Las contraseñas están hasheadas con MD5 para simular un entorno real:
-- - '1234' -> hash: $2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety
-- - '1111'  -> hash: $2y$12$hjnQPM49616CFuI6L8UMOu9v..m.xKkEKKpyyXLKlaRgqeBVDDOO2

INSERT INTO `usuarios` (`nombre_completo`, `usuario`, `password`,`rol`) VALUES
('Administrador Principal', 'admin', '$2y$12$hjnQPM49616CFuI6L8UMOu9v..m.xKkEKKpyyXLKlaRgqeBVDDOO2', 'admin'), -- passwd: 1111
('Usuario de Prueba', 'ana', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'user'); -- passwd: 1234

-- el resto de tablas se darán en el examen

CREATE USER if not exists'dwes25'@'localhost' IDENTIFIED BY 'dwes';

-- Asignar permisos CRUD
GRANT SELECT, INSERT, UPDATE, DELETE ON examen_dwes_3.* TO 'dwes25'@'localhost';
FLUSH PRIVILEGES;