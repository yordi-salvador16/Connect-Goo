-- =============================================
-- MIGRACIÓN: Crear tabla ciudades
-- Connectgoo - Escalabilidad Multi-Ciudad
-- =============================================

CREATE TABLE IF NOT EXISTS ciudades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    departamento VARCHAR(100),
    pais VARCHAR(50) DEFAULT 'Perú',
    activa TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ciudades iniciales
INSERT INTO ciudades (nombre, slug, departamento, pais, activa) VALUES
('Tingo María', 'tingo-maria', 'Huánuco', 'Perú', 1),
('Lima', 'lima', 'Lima', 'Perú', 0),
('Huancayo', 'huancayo', 'Junín', 'Perú', 0),
('Arequipa', 'arequipa', 'Arequipa', 'Perú', 0),
('Trujillo', 'trujillo', 'La Libertad', 'Perú', 0);

-- Agregar columna ciudad_id a trabajadores
ALTER TABLE trabajadores ADD COLUMN ciudad_id INT DEFAULT 1;

-- Asignar todos los trabajadores existentes a Tingo María (id=1)
UPDATE trabajadores SET ciudad_id = 1;
