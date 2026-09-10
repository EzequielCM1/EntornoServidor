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

-- TABLA: paquetes
CREATE TABLE paquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    destino VARCHAR(255) NOT NULL,
    peso DECIMAL(10,2) NOT NULL,
    volumen DECIMAL(10,2) NOT NULL,
    prioridad ENUM('Alta', 'Media', 'Baja') NOT NULL DEFAULT 'Media',
    estado ENUM('Pendiente', 'En Transito', 'Entregado', 'Cancelado') DEFAULT 'Pendiente',
    vehiculo_id INT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INSERTAR DATOS: empleados
-- Contrasenas encriptadas (todas son: 1234)
INSERT INTO empleados (id_empleado, nombre, apellidos, pin, rol) VALUES
('EMP01', 'Juan', 'Pérez García', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'Supervisor'),
('EMP02', 'María', 'López Sánchez', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Conductor'),
('EMP03', 'Carlos', 'Rodríguez Martín', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Conductor'),
('EMP04', 'Ana', 'Fernández Ruiz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operario'),
('EMP05', 'Pedro', 'Gómez Torres', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operario');

-- INSERTAR DATOS: vehiculos
INSERT INTO vehiculos (nombre, matricula, carga_maxima, volumen_maximo, combustible, km, estado, imagen) VALUES
('Camión Grande', 'ABC-1234', 5000.00, 25.00, 'Diesel', 125340, 'Disponible', 'camion1.png'),
('Furgoneta Mediana', 'XYZ-5678', 2000.00, 12.00, 'Gasolina', 87450, 'Disponible', 'furgoneta.png'),
('Moto de Reparto', 'MOT-9012', 150.00, 0.50, 'Gasolina', 34200, 'Disponible', 'moto.png'),
('Camión Pequeño', 'DEF-3456', 3000.00, 15.00, 'Diesel', 98760, 'Disponible', 'camion2.png'),
('Furgoneta Grande', 'GHI-7890', 2500.00, 18.00, 'Diesel', 156890, 'En Ruta', 'furgoneta2.png'),
('Camión Refrigerado', 'JKL-2468', 4000.00, 20.00, 'Diesel', 203450, 'Mantenimiento', 'camion_refrigerado.png');


INSERT INTO paquetes (codigo, destino, peso, volumen, prioridad, estado, vehiculo_id) VALUES
('PKG-001', 'Sevilla, Calle Mayor 45', 480.00, 7.50, 'Alta', 'Pendiente', NULL),
('PKG-002', 'Córdoba, Av. Libertad 12', 5.00, 0.05, 'Alta', 'Pendiente', NULL),
('PKG-003', 'Málaga, Plaza España 8', 120.00, 2.80, 'Alta', 'Pendiente', NULL),
('PKG-004', 'Granada, Camino Real 22', 25.00, 0.45, 'Media', 'Pendiente', NULL),
('PKG-005', 'Cádiz, Paseo Maritimo 5', 15.00, 0.20, 'Baja', 'Pendiente', NULL),
('PKG-006', 'Huelva, C/ del Puerto 15', 500.00, 9.00, 'Media', 'Pendiente', NULL),
('PKG-007', 'Jaén, Av. Andalucía 30', 12.00, 0.15, 'Media', 'Pendiente', NULL),
('PKG-008', 'Almería, Plaza de Toros 7', 420.00, 6.00, 'Baja', 'Pendiente', NULL),
('PKG-009', 'Dos Hermanas, C/ Convento 18', 0.80, 0.01, 'Alta', 'Pendiente', NULL),
('PKG-010', 'Utrera, Av. S. Juan Bosco 25', 85.00, 1.80, 'Media', 'Pendiente', NULL),
('PKG-011', 'Ecija, Plaza de España 10', 2.10, 0.03, 'Media', 'Pendiente', NULL),
('PKG-012', 'Carmona, Calle Prim 33', 75.00, 1.20, 'Baja', 'Pendiente', NULL),
('PKG-013', 'Alcalá de G., C/ Cervantes 5', 350.00, 5.20, 'Alta', 'Pendiente', NULL),
('PKG-014', 'Mairena Alcor, Av. Const. 8', 0.50, 0.01, 'Baja', 'Pendiente', NULL),
('PKG-015', 'La Rinconada, C/ Real 42', 190.00, 3.50, 'Baja', 'Pendiente', NULL),
('PKG-100', 'Sevilla, Calle Betis 12', 450.00, 7.50, 'Alta', 'Entregado', 5),
('PKG-101', 'Córdoba, Avenida del Brillante 22', 320.00, 5.00, 'Media', 'Entregado', 5),
('PKG-102', 'Málaga, Calle Larios 8', 180.00, 3.00, 'Alta', 'En Transito', 5);

-- COMENTARIOS Y NOTAS
-- Las contrasenas estan encriptadas con password_hash de PHP
-- Para generar una nueva: password_hash('1234', PASSWORD_DEFAULT)
-- Para verificar: password_verify('1234', $hash_almacenado)
--
CREATE USER if not exists'dwes25'@'localhost' IDENTIFIED BY 'dwes';

-- Asignar permisos CRUD
GRANT SELECT, INSERT, UPDATE, DELETE ON monroy_delivery.* TO 'dwes25'@'localhost';

FLUSH PRIVILEGES;