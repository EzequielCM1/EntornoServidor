-- SQL PARA EL SIMULACRO DE EXAMEN
-- Módulo de Entrenamiento

-- 1. Crear la tabla de entrenamientos si no existe
CREATE TABLE IF NOT EXISTS entrenamientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_animal INT NOT NULL,
    nivel ENUM('Básico', 'Medio', 'Avanzado') NOT NULL,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_animal) REFERENCES animales(id) ON DELETE CASCADE
);

-- 2. Asegurarnos de que haya animales en estado 'Sano' para probar
-- (Ajusta los IDs si es necesario o crea animales nuevos)
INSERT INTO animales (nombre, especie, estado) VALUES 
('Rocky', 'Perro', 'Sano'),
('Misi', 'Gato', 'Sano'),
('Kira', 'Perro', 'Sano')
ON DUPLICATE KEY UPDATE estado = 'Sano';

-- 3. Limpiar entrenamientos antiguos para el simulacro
DELETE FROM entrenamientos;

-- RECUERDA: El campo 'estado' de la tabla 'animales' debe poder aceptar el valor 'En Entrenamiento'.
-- Si no es un ENUM o no lo permite, cámbialo:
-- ALTER TABLE animales MODIFY COLUMN estado VARCHAR(50);
