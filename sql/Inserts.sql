USE blog;

-- Insertar usuarios
INSERT INTO usuarios (nombre, apellidos, email, username, contrasena, rol) VALUES
('Juan', 'Pérez', 'juan@example.com', 'juan', 'contraseña123', 'admin'),
('María', 'González', 'maria@example.com', 'maria', 'clave456', 'usur'), 
('Pedro', 'Martínez', 'pedro@example.com', 'pedro', 'secreto789', 'usur'); 

-- Insertar categorías
INSERT INTO categorias (nombre) VALUES
('Tecnología'),
('Viajes'),
('Cocina');

-- Insertar entradas
INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES
(1, 1, 'Introducción a SQL', 'En este artículo aprenderás los conceptos básicos de SQL.', '2024-05-01'),
(2, 2, 'Mi viaje a París', 'Comparto mi experiencia y consejos para viajar a la Ciudad de la Luz.', '2024-04-15'),
(3, 3, 'Receta de lasaña', 'Una deliciosa receta paso a paso para preparar lasaña casera.', '2024-04-30'),
(1, 2, 'Mis vacaciones en la playa', 'Relato de mis vacaciones de verano en la costa.', '2024-06-10'),
(2, 1, 'Introducción a Python', 'Una breve introducción al lenguaje de programación Python.', '2024-05-20');
