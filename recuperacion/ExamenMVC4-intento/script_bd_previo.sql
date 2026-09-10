-- BASE DE DATOS: MONROY DELIVERY

-- Crear base de datos
DROP DATABASE IF EXISTS monroy_delivery;
CREATE DATABASE monroy_delivery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE monroy_delivery;

-- TABLA: empleados
-- Nota: id_empleado debe tener formato de 3 letras mayusculas mas 2 numeros
-- Ejemplo: EMP01, SUP02, OPE03
CREATE TABLE empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado VARCHAR(5) UNIQUE NOT NULL CHECK (id_empleado REGEXP '^[A-Z]{3}[0-9]{2}$'),
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    pin VARCHAR(255) NOT NULL,
    rol ENUM('Supervisor', 'Conductor', 'Operario') DEFAULT 'Operario',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLA: vehiculos
CREATE TABLE vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    carga_maxima DECIMAL(10,2) NOT NULL,
    volumen_maximo DECIMAL(10,2) NOT NULL,
    combustible ENUM('Gasolina', 'Diesel', 'Eléctrico', 'Híbrido') NOT NULL DEFAULT 'Diesel',
    km INT UNSIGNED NOT NULL DEFAULT 0,
    estado ENUM('Disponible', 'En Ruta', 'Mantenimiento') DEFAULT 'Disponible',
    imagen VARCHAR(255) NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- INSERTAR DATOS: empleados
-- Contrasenas encriptadas (todas son: 1234)
INSERT INTO empleados (id_empleado, nombre, apellidos, pin, rol) VALUES
('EMP01', 'Juan', 'Pérez García', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Supervisor'),
('EMP02', 'María', 'López Sánchez', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Conductor'),
('EMP03', 'Carlos', 'Rodríguez Martín', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Conductor'),
('EMP04', 'Ana', 'Fernández Ruiz', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Operario'),
('EMP05', 'Pedro', 'Gómez Torres', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Operario');

-- INSERTAR DATOS: vehiculos
INSERT INTO vehiculos (nombre, matricula, carga_maxima, volumen_maximo, combustible, km, estado, imagen) VALUES
('Camión Grande', 'ABC-1234', 5000.00, 25.00, 'Diesel', 125340, 'Disponible', 'camion1.png'),
('Furgoneta Mediana', 'XYZ-5678', 2000.00, 12.00, 'Gasolina', 87450, 'Disponible', 'furgoneta.png'),
('Moto de Reparto', 'MOT-9012', 150.00, 0.50, 'Gasolina', 34200, 'Disponible', 'moto.png'),
('Camión Pequeño', 'DEF-3456', 3000.00, 15.00, 'Diesel', 98760, 'Disponible', 'camion2.png'),
('Furgoneta Grande', 'GHI-7890', 2500.00, 18.00, 'Diesel', 156890, 'En Ruta', 'furgoneta2.png'),
('Camión Refrigerado', 'JKL-2468', 4000.00, 20.00, 'Diesel', 203450, 'Mantenimiento', 'camion_refrigerado.png');

CREATE USER if not exists'dwes25'@'localhost' IDENTIFIED BY 'dwes';

-- Asignar permisos CRUD
GRANT SELECT, INSERT, UPDATE, DELETE ON monroy_delivery.* TO 'dwes25'@'localhost';

FLUSH PRIVILEGES;
