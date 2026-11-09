-- Base de datos del formulario de contacto
-- Autora: Laura Sofía Ramos Rueda
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(120) NOT NULL,
    correo VARCHAR(190) NOT NULL,
    telefono VARCHAR(30) NULL,
    asunto VARCHAR(50) NOT NULL,
    mensaje TEXT NOT NULL,
    acepta_tratamiento TINYINT(1) NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO contactos (nombre_completo, correo, telefono, asunto, mensaje, acepta_tratamiento) VALUES
('Laura Sofía Ramos Rueda', 'laura.ramos@example.com', '3001234567', 'Consulta General', 'Primer registro de prueba del formulario.', 1),
('Carlos Andrés Pérez', 'carlos.perez@example.com', '3109876543', 'Soporte técnico', 'No puedo ingresar a la plataforma.', 1),
('Valentina Torres Díaz', 'valentina.torres@example.com', '3205551234', 'Solicitud de información', 'Quisiera saber los horarios de atención.', 1),
('Santiago Morales Gil', 'santiago.morales@example.com', NULL, 'Otro', 'Felicitaciones por el formulario.', 1),
('Daniela Castro Vargas', 'daniela.castro@example.com', '3157778899', 'Consulta General', 'Necesito más información del programa.', 1);
