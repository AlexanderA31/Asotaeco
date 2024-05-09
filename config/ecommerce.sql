DROP DATABASE IF EXISTS u823153798_ecomerce1;
CREATE DATABASE IF NOT EXISTS `u823153798_ecomerce1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `u823153798_ecomerce1`;

-- Crear tabla de género
CREATE TABLE genero (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20),
    est INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de tipo de prenda
CREATE TABLE tipo_prenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    est INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Crear tabla de ocasión
CREATE TABLE ocasion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    est INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    id_genero INT,
    id_tipo_prenda INT,
    id_ocasion INT,
    est INT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (id_genero) REFERENCES genero(id),
    FOREIGN KEY (id_tipo_prenda) REFERENCES tipo_prenda(id),
    FOREIGN KEY (id_ocasion) REFERENCES ocasion(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de imágenes de productos
CREATE TABLE imagenes_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    url_imagen VARCHAR(255),
    orden INT,
    est INT DEFAULT 1,
    FOREIGN KEY (id_producto) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE colores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    color VARCHAR(255),
    color_hexa VARCHAR(255) DEFAULT"",
    est INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE tallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    talla VARCHAR(255),
    desc_talla VARCHAR(255) DEFAULT"",
    est INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Crear tabla de inventario de productos
CREATE TABLE inventario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    id_color INT,
    id_talla INT,
    stock INT,
    stock_alert INT DEFAULT 5,
    precio DECIMAL(10, 2),
    FOREIGN KEY (id_producto) REFERENCES productos(id),
     FOREIGN KEY (id_talla) REFERENCES tallas(id),
      FOREIGN KEY (id_color) REFERENCES colores(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE inventario
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Crear tabla de proveedores
CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruc VARCHAR(15) DEFAULT NULL,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    est INT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de relación entre proveedores y productos
CREATE TABLE productos_proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    id_proveedor INT,
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `roles` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(200) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `sliders` (
   id INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` varchar(250) NOT NULL DEFAULT '',
  `descripcion` varchar(250) NOT NULL DEFAULT '',
  `img` varchar(250) NOT NULL DEFAULT '',
  `url_web` varchar(250) NOT NULL DEFAULT '',
  `est` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `resetPass` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(250) NOT NULL DEFAULT '',
  `cod` varchar(250) NOT NULL DEFAULT '',
   fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `rol_id` int(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `provincia` text DEFAULT NULL,
  `canton` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
   `referencia` text DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `cedula` varchar(20) NOT NULL,
  `est` int(1) DEFAULT 1,
  UNIQUE KEY `cedula` (`cedula`),
  UNIQUE KEY `kEmail` (`email`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE usuarios
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;


CREATE TABLE alertaspedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_inventario INT,
    id_proveedor INT,
    cantidad INT DEFAULT 1,
    `descripcion` text DEFAULT "",
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     `est` int(1) DEFAULT 0,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id),
    FOREIGN KEY (id_user) REFERENCES usuarios(id),
      FOREIGN KEY (id_inventario) REFERENCES inventario(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de compras
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    id_proveedor INT,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id),
    FOREIGN KEY (id_user) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla de detalles de compra
CREATE TABLE detalles_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT,
    id_variante_producto INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    est INT DEFAULT 1,
    FOREIGN KEY (id_compra) REFERENCES compras(id),
    FOREIGN KEY (id_variante_producto) REFERENCES inventario(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Crear tabla de información de quién recibe la venta
CREATE TABLE recibe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ci VARCHAR(15) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    `provincia` text DEFAULT NULL,
  `canton` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
   `referencia` text DEFAULT NULL,
    est INT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Crear tabla de ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_recibe INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    envio DECIMAL(10, 2) DEFAULT 0,
    isenvio INT DEFAULT 0,
    est_pago INT DEFAULT 0,
    guia_servi VARCHAR(50) DEFAULT NULL,
    metodo_pago INT DEFAULT 1, 
    -- 1 Retiro en oficina 2 Transferencia
    ncomprobante VARCHAR(255) DEFAULT NULL,
    comprobante VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (id_recibe) REFERENCES recibe(id),
    FOREIGN KEY (id_client) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE detalles_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    id_variante_producto INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_variante_producto) REFERENCES inventario(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `wish_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `est` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
