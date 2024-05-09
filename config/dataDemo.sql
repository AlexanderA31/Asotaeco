INSERT INTO `roles` (`id`, `nombre`, `est`) VALUES
(1, 'administrador', 1),
(2, 'cliente', 1);

INSERT INTO `sliders` (`id`, `titulo`, `descripcion`, `img`, `url_web`, `est`) VALUES
(1, 'Chaquetas & Chompas', 'coleccion de chaquetas 2024', '../../public/images/sliders/slide-01.jpg', '', 1),
(2, 'Camisas & Blusas', 'Camisas para hombre y mujer 2024', '../../public/images/sliders/slide-02.jpg', '', 1),
(3, 'Uniformes de niño & niña', 'se diseña los uniformes para colegios 2024', '../../public/images/sliders/slide-03.jpg', '', 1);


INSERT INTO `usuarios` (`rol_id`, `email`, `pass`, `nombre`, `direccion`, `cedula`, `est`) VALUES
( 1, 'paulluna99@gmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Alexannder Luna', 'San Miguel de Bolivar', '0202433919', 1),
( 2, 'bryan@nose.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Bryan Shiguango', 'Tena', '0202433123', 1),
( 2, 'user@gmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Nicole Anahi', 'Guaranda', '0202433321', 1),
( 2, 'xd@hotmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'xd', 'user1direcion', '0202433231', 1),
( 1, 'admin@admin.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Admin', 'admin direccion', '0202433312', 1);


INSERT INTO proveedores (ruc, nombre, email, telefono, direccion, est) VALUES ('1234567890', 'Proveedor Uno', 'proveedoruno@example.com', '1234567890', 'Calle Uno #123', 1),
 ('2345678901', 'Proveedor Dos', 'proveedordos@example.com', '593985726434', 'Avenida Dos #456', 1),
('3456789012', 'Proveedor Tres', 'proveedortres@example.com', '593985726434', 'Calle Tres #789', 1),
('4567890123', 'Proveedor Cuatro', 'proveedorcuatro@example.com', '593985726434', 'Avenida Cuatro #012', 1),
 ('5678901234', 'Proveedor Cinco', 'proveedorcinco@example.com', '593985726434', 'Calle Cinco #345', 1);

-- Insertar datos en la tabla de ocasión
INSERT INTO ocasion (nombre) VALUES 
('Formal'), 
('Uniforme Escolar'), 
('Casual'), 
('Deportivo');

-- Insertar datos en la tabla de género
INSERT INTO genero (nombre) VALUES ('Niño'), ('Niña'), ('Hombre'), ('Mujer');

-- Insertar datos en la tabla de tipo de prenda
INSERT INTO tipo_prenda (nombre) VALUES 
('Camisa'), 
('Pantalón'), 
('Falda'), 
('Camiseta'), 
('Chompa'), 
('Abrigo');
INSERT INTO tallas (id, talla, desc_talla, est) VALUES
(1, 'S', 'Pequeña', 1),
(2, 'M', 'Mediana', 1),
(3, 'L', 'Grande', 1);
INSERT INTO colores (id, color, color_hexa, est) VALUES
(1, 'Negro', '#000000', 1),
(2, 'Blanco', '#FFFFFF', 1),
(3, 'Azul', '#0000FF', 1),
(4, 'Rojo', '#FF0000', 1),
(5, 'Verde', '#00FF00', 1),
(6, 'Gris', '#808080', 1),
(7, 'Amarillo', '#FFFF00', 1),
(8, 'Naranja', '#FFA500', 1),
(9, 'Rosado', '#FFC0CB', 1),
(10, 'Morado', '#800080', 1);


INSERT INTO productos (id, nombre, descripcion, id_genero, id_tipo_prenda, id_ocasion) VALUES
(1, 'Camisa blanca', 'Camisa blanca de manga larga', 1, 1, 1),
(2, 'Pantalones vaqueros', 'Pantalones vaqueros azules', 1, 2, 2),
(3, 'Vestido floral', 'Vestido floral de verano', 2, 3, 3),
(4, 'Chaqueta de cuero', 'Chaqueta de cuero negro', 1, 4, 1),
(5, 'Sudadera con capucha', 'Sudadera con capucha gris', 1, 5, 3),
(6, 'Falda plisada', 'Falda plisada de color rosa', 2, 6, 3),
(7, 'Zapatos de tacón', 'Zapatos de tacón negros', 2, 1, 2),
(8, 'Bufanda de lana', 'Bufanda de lana suave', 1, 2, 1),
(9, 'Gorra de béisbol', 'Gorra de béisbol roja', 1, 3, 1),
(10, 'Abrigo de invierno', 'Abrigo de invierno acolchado', 1, 4, 1),
(11, 'Blusa estampada', 'Blusa estampada de manga corta', 2, 5, 3),
(12, 'Pantalones cortos', 'Pantalones cortos de algodón', 1, 6, 2),
(13, 'Vestido de noche', 'Vestido de noche elegante', 2, 1, 2),
(14, 'Chaleco acolchado', 'Chaleco acolchado de plumas', 1, 2, 1),
(15, 'Zapatos deportivos', 'Zapatos deportivos blancos', 1, 3, 2),
(16, 'Jersey de lana', 'Jersey de lana verde', 2, 4, 1),
(17, 'Gafas de sol', 'Gafas de sol de estilo retro', 1, 5, 2),
(18, 'Pantalones cargo', 'Pantalones cargo de color caqui', 1, 6, 3),
(19, 'Vestido de fiesta', 'Vestido de fiesta rojo', 2, 1, 1),
(20, 'Camiseta sin mangas', 'Camiseta sin mangas de color negro', 1, 2, 2),
(21, 'Sombrero de paja', 'Sombrero de paja de ala ancha', 2, 3, 1),
(22, 'Chaqueta vaquera', 'Chaqueta vaquera desgastada', 1, 4, 2),
(23, 'Calcetines de algodón', 'Calcetines de algodón cómodos', 1, 5, 3),
(24, 'Vestido de cóctel', 'Vestido de cóctel elegante', 2, 6, 3),
(25, 'Chaleco de punto', 'Chaleco de punto gris', 1, 1, 1),
(26, 'Zapatillas de estar por casa', 'Zapatillas de estar por casa cómodas', 2, 2, 1),
(27, 'Camiseta polo', 'Camiseta polo de manga corta', 4, 3, 1),
(28, 'Bufanda de seda', 'Bufanda de seda suave', 3, 4, 1),
(29, 'Gabardina', 'Gabardina beige clásica', 2, 5, 2),
(30, 'Pantalones de vestir', 'Pantalones de vestir de color gris', 1, 6, 3);

INSERT INTO imagenes_producto (id_producto, url_imagen, orden, est) VALUES
(1, '../../public/images/products/product-01.jpg', 1, 1),
(1, '../../public/images/products/product-02.jpg', 2, 1),
(2, '../../public/images/products/product-03.jpg', 1, 1),
(2, '../../public/images/products/product-04.jpg', 2, 1);


