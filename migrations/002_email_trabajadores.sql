-- Agregar columna email a trabajadores
ALTER TABLE trabajadores ADD COLUMN email VARCHAR(255) DEFAULT NULL AFTER nombre;
