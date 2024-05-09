<?php
require_once '../config/Conectar.php';

class ProductModel extends Conectar
{
    public function getAllProducts()
    {
        try {
            $conexion = parent::Conexion();

            $sql = "SELECT tp.nombre as tipo_prenda,tp.*, oc.nombre as ocasion, p.*, g.nombre AS genero, img.url_imagen AS imagen
            FROM productos p
            INNER JOIN genero g ON p.id_genero = g.id
            INNER JOIN ocasion oc ON p.id_ocasion = oc.id
            INNER JOIN tipo_prenda tp ON p.id_tipo_prenda = tp.id
            LEFT JOIN imagenes_producto img ON img.id_producto = p.id AND img.est = 1 AND img.orden = 1
            ;";


            $stmt = $conexion->prepare($sql);


            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getAllProductsStock()
    {
        try {
            $conexion = parent::Conexion();
            $id = $_GET['id'];
            $sql = "SELECT 
            SUM(i.stock) as stock_total,
            oc.nombre as ocasion, 
            i.*, 
            p.*, 
            c.color, 
            g.nombre AS genero, 
            t.desc_talla, 
            t.talla, 
            img.url_imagen AS imagen,
            AVG(i.precio) as precio_promedio
        FROM 
            inventario i
        INNER JOIN 
            productos p ON i.id_producto = p.id
        INNER JOIN 
            genero g ON p.id_genero = g.id
        INNER JOIN 
            ocasion oc ON p.id_ocasion = oc.id
        LEFT JOIN 
            colores c ON i.id_color = c.id
        LEFT JOIN 
            tallas t ON i.id_talla = t.id
        LEFT JOIN 
            imagenes_producto img ON img.id_producto = i.id_producto AND img.est = 1 AND img.orden = 1 
        
        
                        ";
            if ($id != null) {
                $sql .= 'WHERE 
                p.id = ? 
            GROUP BY 
                p.id, oc.nombre, c.color, g.nombre, t.desc_talla, t.talla, img.url_imagen';
            } else {
                $sql .= ' GROUP BY i.id_talla,i.id_color,i.id_producto';
            }

            $stmt = $conexion->prepare($sql);
            if ($id != null) {
                $stmt->bindValue(1, $id);
            }

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getProductsRecent()
    {
        try {
            $conexion = parent::Conexion();

            $sql = "SELECT i.*, p.*, 
            GROUP_CONCAT(DISTINCT t.talla ORDER BY t.id SEPARATOR ', ') AS tallas, 
            oc.nombre as ocasion, g.nombre AS genero, 
            img1.url_imagen AS imagen1, img2.url_imagen AS imagen2
        FROM (
            SELECT *,
                ROW_NUMBER() OVER (PARTITION BY id_producto ORDER BY precio) AS row_num
            FROM inventario
            WHERE stock > 0
        ) AS i
        JOIN tallas AS t ON t.id = i.id_talla
        JOIN productos AS p ON i.id_producto = p.id
        JOIN genero AS g ON p.id_genero = g.id
        JOIN ocasion AS oc ON oc.id = p.id_ocasion
        LEFT JOIN (
            SELECT id_producto, url_imagen
            FROM imagenes_producto
            WHERE est = 1 AND orden = 1
        ) AS img1 ON img1.id_producto = i.id_producto
        LEFT JOIN (
            SELECT id_producto, url_imagen
            FROM imagenes_producto
            WHERE est = 1 AND orden = 2
        ) AS img2 ON img2.id_producto = i.id_producto
        WHERE i.row_num = 1
        GROUP BY i.id_producto
        LIMIT 8;";


            $stmt = $conexion->prepare($sql);

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }


    public function deleteImgProduct()
    {
        try {
            $conexion = parent::Conexion();
            $id_imagen = $_POST['id'];
            $sql = "SELECT url_imagen FROM imagenes_producto WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id_imagen);
            $stmt->execute();
            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
            $url_imagen = substr($imagen['url_imagen'], 3);
            if (!unlink($url_imagen)) {
                throw new Exception("Error al eliminar la imagen del almacenamiento");
            }

            $sqlDelete = "DELETE FROM imagenes_producto WHERE id = ?";
            $stmtDelete = $conexion->prepare($sqlDelete);
            $stmtDelete->bindValue(1, $id_imagen);
            $stmtDelete->execute();

            return true; // La eliminación fue exitosa
        } catch (PDOException $e) {
            return ("Error al eliminar la imagen: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    public function getImagesProducts()
    {
        try {
            $conexion = parent::Conexion();
            $id = $_GET['id'];

            $sql = "SELECT * FROM imagenes_producto img
            WHERE img.id_producto = ? 
            ORDER BY orden ASC;
            ";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function insertImgsProduct()
    {
        try {
            $conexion = parent::Conexion();
            $conexion->beginTransaction();

            $id_producto =  $_POST["id_producto"];
            $id_img =  $_POST["id_img"];
            // Verificar si se han enviado imágenes
            if (!empty($_FILES["imagenes"]["name"])) {
                $rutaImagenes = '../public/images/products/';
                for ($i = 0; $i < count($_FILES["imagenes"]["name"]); $i++) {
                    $nombreImagen = uniqid();
                    if (!move_uploaded_file($_FILES["imagenes"]["tmp_name"][$i], $rutaImagenes . $nombreImagen . '.webp')) {
                        throw new Exception("Error al mover la imagen a la carpeta de destino");
                    }
                    $url_imagen = "../../public/images/products/" . $nombreImagen . '.webp';
                    $orden = $i + 1; // Se asigna un orden secuencial a las imágenes
                    $stmtImagen = $conexion->prepare("INSERT INTO imagenes_producto (id_producto, url_imagen, orden, est) VALUES (?, ?, ?, ?)");
                    $stmtImagen->bindValue(1, $id_producto);
                    $stmtImagen->bindValue(2, $url_imagen);
                    $stmtImagen->bindValue(3, $orden);
                    $stmtImagen->bindValue(4, 1);
                    $stmtImagen->execute();
                }
            }
            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }
    public function updateImgsProduct()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $conexion->beginTransaction(); // Iniciar una transacción

            $id_img =  $_POST["id_img"];
            $id_producto =  $_POST["id_producto"];
            $new_order = $_POST["orden"];

            // Obtener todas las imágenes del producto ordenadas por su orden actual
            $stmt = $conexion->prepare("SELECT id FROM imagenes_producto WHERE id_producto = ? ORDER BY orden");
            $stmt->bindValue(1, $id_producto);
            $stmt->execute();
            $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Actualizar el orden de la imagen especificada
            $stmt = $conexion->prepare("UPDATE imagenes_producto SET orden = ? WHERE id = ?");
            $stmt->bindValue(1, $new_order);
            $stmt->bindValue(2, $id_img);
            $stmt->execute();

            // Recalcular los números de orden para todas las imágenes
            foreach ($imagenes as $key => $imagen_id) {
                $orden = $key + 1;
                if ($orden != $new_order) {
                    $stmt = $conexion->prepare("UPDATE imagenes_producto SET orden = ? WHERE id = ?");
                    $stmt->bindValue(1, $orden);
                    $stmt->bindValue(2, $imagen_id);
                    $stmt->execute();
                }
            }

            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }

    public function getProductsShop()
    {
        try {
            $conexion = parent::Conexion();

            $sql = "SELECT i.*, p.*,oc.nombre as ocasion, g.nombre AS genero, img.url_imagen AS imagen
            FROM (
                SELECT *,
                       ROW_NUMBER() OVER (PARTITION BY id_producto ORDER BY precio) AS row_num
                FROM inventario
                WHERE stock > 0
            ) AS i
            JOIN productos AS p ON i.id_producto = p.id
            JOIN genero AS g ON p.id_genero = g.id
            JOIN ocasion AS oc ON oc.id = p.id_ocasion
            LEFT JOIN imagenes_producto AS img ON img.id_producto = i.id_producto AND img.est = 1 AND img.orden = 1
            WHERE i.row_num = 1 ORDER BY g.id DESC;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getPrecioShop()
    {
        try {
            $talla_id = $_GET['talla_id'];
            $color_id = $_GET['color_id'];
            $prod_id = $_GET['prod_id'];
            $conexion = parent::Conexion();

            $sql = "SELECT id_producto, id_color, id_talla, AVG(precio) AS precio, SUM(stock) AS stock
                    FROM inventario
                    WHERE id_talla = ? AND id_producto = ? AND id_color = ? 
                    GROUP BY id_producto, id_color, id_talla";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $talla_id);
            $stmt->bindValue(2, $prod_id);
            $stmt->bindValue(3, $color_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getProducts()
    {
        try {
            $conexion = parent::Conexion();

            $sql = "SELECT  p.*, img.url_imagen as imagen
            FROM productos p 
            LEFT JOIN imagenes_producto img ON img.id_producto = p.id AND img.est = 1 AND img.orden = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getProductsAlert()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT 
            i.id AS id_inventario,
            i.id_producto, 
            i.id_talla, 
            i.id_color, 
            SUM(i.stock) AS total_stock, 
            p.nombre AS nombre_producto, 
            p.descripcion AS descripcion_producto,
            c.color, 
            t.desc_talla, 
            t.talla,
            img.url_imagen AS imagen
        FROM 
            inventario i
        INNER JOIN 
            productos p ON i.id_producto = p.id
        INNER JOIN 
            colores c ON i.id_color = c.id
        INNER JOIN 
            tallas t ON i.id_talla = t.id
        LEFT JOIN 
            imagenes_producto img ON img.id_producto = i.id_producto AND img.orden = 1
        WHERE 
            p.est = 1 
        GROUP BY 
            i.id_producto, 
            i.id_talla, 
            i.id_color
        HAVING 
            SUM(i.stock) <= 5
        ;";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getAllColores()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM colores";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getColores()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM colores WHERE est=1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getProductDetail()
    {
        $p_id = $_GET["id"];
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT sub.* 
            FROM (
                SELECT p.id, p.nombre, p.descripcion, COALESCE(i.precio, 'No disponible') AS precio, 
                       COALESCE(i.stock, 0) AS stock, COALESCE(i.id_talla, 'Sin talla') AS id_talla, 
                       COALESCE(i.id_color, 'Sin color') AS id_color,
                       ROW_NUMBER() OVER (PARTITION BY p.id ORDER BY i.precio) AS row_num
                FROM productos AS p
                LEFT JOIN inventario AS i ON i.id_producto = p.id
                WHERE p.id = ?
            ) AS sub
            WHERE sub.row_num = 1;
            ;
             ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }



    public function getImgProd()
    {
        $conexion = parent::Conexion();
        $p_id = $_GET["id"];
        try {
            $sql = "SELECT url_imagen 
                FROM imagenes_producto
                WHERE id_producto = ? AND est = 1 AND orden=1";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function estImgProduct()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE imagenes_producto SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del proveedor");
            }
        } catch (PDOException $e) {
            return ("Error al cambiar el estado del proveedor: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    public function getAllImgProd()
    {
        $conexion = parent::Conexion();
        $p_id = $_GET["id"];
        try {
            $sql = "SELECT * 
            FROM imagenes_producto
            WHERE id_producto = ? AND est = 1
            ORDER BY orden ASC;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getWishList()
    {
        $conexion = parent::Conexion();
        $p_id = $_GET["id_user"];
        try {
            $sql = "SELECT p.nombre, p.id, p.precio, p.existencia, COALESCE(pf.url_imagen, '') AS img
                FROM Wish_List AS w
                INNER JOIN productos AS p ON p.id = w.id_producto
                LEFT JOIN imagenes_producto AS pf ON p.id = pf.id_producto AND pf.est = 1
                WHERE w.id_usuario = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getColoresTalla()
    {
        try {
            $p_id = $_GET["id_prod"];
            $talla = $_GET["talla"];
            $conexion = parent::Conexion();
            $sql = "SELECT DISTINCT col.id AS id_color, col.color ,i.id_talla
                FROM inventario AS i
                INNER JOIN colores AS col ON i.id_color = col.id
                WHERE i.id_producto = ? AND i.id_talla = ?;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->bindValue(2, $talla);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getTallasColor()
    {
        try {
            $p_id = $_GET["id_prod"];
            $color = $_GET["color"];
            $conexion = parent::Conexion();
            $sql = "SELECT DISTINCT t.* ,i.id_talla,i.id_color
                FROM inventario AS i
                INNER JOIN tallas AS t ON i.id_talla = t.id
                WHERE i.id_producto = ? AND i.id_color = ?;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->bindValue(2, $color);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }


    public function deleteProduct()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE productos SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del proveedor");
            }
        } catch (PDOException $e) {
            return ("Error al cambiar el estado del proveedor: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }


    public function updateProduct()
    {
        try {
            $id_producto = $_POST["id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $id_genero = $_POST["id_genero"];
            $id_tipo_prenda = $_POST["id_tipo_prenda"];
            $id_ocasion = $_POST["id_ocasion"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $conexion->beginTransaction();

            $sqlProducto = "UPDATE productos SET nombre=?, descripcion=?, id_genero=?, id_tipo_prenda=?, id_ocasion=?,est=? WHERE id=?";
            $stmtProducto = $conexion->prepare($sqlProducto);
            $stmtProducto->bindValue(1, $nombre);
            $stmtProducto->bindValue(2, $descripcion);
            $stmtProducto->bindValue(3, $id_genero);
            $stmtProducto->bindValue(4, $id_tipo_prenda);
            $stmtProducto->bindValue(5, $id_ocasion);
            $stmtProducto->bindValue(6, $est);
            $stmtProducto->bindValue(7, $id_producto);
            $stmtProducto->execute();

            // Eliminar las imágenes anteriores del producto (opcional, según la lógica de tu aplicación)

            // Insertar las nuevas rutas de las imágenes en la tabla imagenes_productos
            if (!empty($_FILES["imagenes"]["name"])) {
                $rutaImagenes = '../public/images/products/';
                for ($i = 0; $i < count($_FILES["imagenes"]["name"]); $i++) {
                    $nombreImagen = uniqid();
                    if (!move_uploaded_file($_FILES["imagenes"]["tmp_name"][$i], $rutaImagenes . $nombreImagen . '.webp')) {
                        throw new Exception("Error al mover la imagen a la carpeta de destino");
                    }
                    $url_imagen = "../../public/images/products/" . $nombreImagen . '.webp';
                    $orden = $i + 1;
                    $stmtImagen = $conexion->prepare("INSERT INTO imagenes_producto (id_producto, url_imagen, orden, est) VALUES (?, ?, ?, ?)");
                    $stmtImagen->bindValue(1, $id_producto);
                    $stmtImagen->bindValue(2, $url_imagen);
                    $stmtImagen->bindValue(3, $orden);
                    $stmtImagen->bindValue(4, 1); // Valor por defecto para est
                    $stmtImagen->execute();
                }
            }
            return  $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }

    public function insertProduct()
    {
        try {
            // Obtener los datos enviados por el formulario
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $id_genero = $_POST["id_genero"];
            $id_tipo_prenda = $_POST["id_tipo_prenda"];
            $id_ocasion = $_POST["id_ocasion"];

            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $conexion->beginTransaction(); // Iniciar una transacción

            // Insertar el producto en la tabla productos
            $sqlProducto = "INSERT INTO productos (nombre, descripcion, id_genero, id_tipo_prenda, id_ocasion) VALUES (?, ?, ?, ?, ? )";
            $stmtProducto = $conexion->prepare($sqlProducto);
            $stmtProducto->bindValue(1, $nombre);
            $stmtProducto->bindValue(2, $descripcion);
            $stmtProducto->bindValue(3, $id_genero);
            $stmtProducto->bindValue(4, $id_tipo_prenda);
            $stmtProducto->bindValue(5, $id_ocasion);
            $stmtProducto->execute();

            // Obtener el ID del producto insertado
            $id_producto = $conexion->lastInsertId();

            // Insertar las rutas de las imágenes en la tabla imagenes_productos
            if (!empty($_FILES["imagenes"]["name"])) {
                $rutaImagenes = '../public/images/products/';
                for ($i = 0; $i < count($_FILES["imagenes"]["name"]); $i++) {
                    $nombreImagen = uniqid();
                    if (!move_uploaded_file($_FILES["imagenes"]["tmp_name"][$i], $rutaImagenes . $nombreImagen . '.webp')) {
                        throw new Exception("Error al mover la imagen a la carpeta de destino");
                    }
                    $url_imagen = "../../public/images/products/" . $nombreImagen . '.webp';
                    $orden = $i + 1; // Se asigna un orden secuencial a las imágenes
                    $stmtImagen = $conexion->prepare("INSERT INTO imagenes_producto (id_producto, url_imagen, orden, est) VALUES (?, ?, ?, ?)");
                    $stmtImagen->bindValue(1, $id_producto);
                    $stmtImagen->bindValue(2, $url_imagen);
                    $stmtImagen->bindValue(3, $orden);
                    $stmtImagen->bindValue(4, 1); // Valor por defecto para est
                    $stmtImagen->execute();
                }
            }

            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }
    public function insertWishClient()
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];

            $id_producto = $_POST["id_producto"];
            $id_user =  $userData['user_id'];
            $conexion = parent::Conexion();
            $conexion->beginTransaction();

            // Verificar si ya existe una fila con el mismo id_variante_producto y id_usuario
            $sqlCheckExistence = "SELECT COUNT(*) FROM wish_list WHERE id_usuario = ? AND id_producto = ?";
            $stmtCheckExistence = $conexion->prepare($sqlCheckExistence);
            $stmtCheckExistence->execute([$id_user, $id_producto]);
            $rowCount = $stmtCheckExistence->fetchColumn();

            if ($rowCount == 0) {
                // Si no existe, realizar la inserción
                $sqlProducto = "INSERT INTO wish_list (id_usuario, id_producto) VALUES (?, ?)";
                $stmtProducto = $conexion->prepare($sqlProducto);
                $stmtProducto->bindValue(1, $id_user);
                $stmtProducto->bindValue(2, $id_producto);
                $stmtProducto->execute();
            }

            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }
    public function setProductPedido($products)
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];
            $conexion = parent::Conexion();
            $conexion->beginTransaction();
            $data = json_decode(file_get_contents('php://input'), true);
            $id_proveedor = $data['id_proveedor'];
            foreach ($products as $product) {
                $id_inventario = $product['id_inventario'];
                $cantidad = $product['cant_pred'];
                $sqlProducto = "INSERT INTO alertaspedido (id_user, id_inventario, id_proveedor, cantidad,est) VALUES (?,?, ?, ?, ?)";
                $stmtProducto = $conexion->prepare($sqlProducto);
                $stmtProducto->bindValue(1, $id_user);
                $stmtProducto->bindValue(2, $id_inventario);
                $stmtProducto->bindValue(3, $id_proveedor);
                $stmtProducto->bindValue(4, $cantidad);
                $stmtProducto->bindValue(5, 1);
                $stmtProducto->execute();
            }

            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }

    public function updateProductPedido()
    {
        try {
            $id = $_POST['id'];
            $descripcion = $_POST['descripcion'];
            $est = $_POST['est'];
            $conexion = parent::Conexion();
            $sql = "UPDATE alertaspedido SET descripcion = ?,est=? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $descripcion);
            $stmt->bindValue(2, $est);
            $stmt->bindValue(3, $id);
            $stmt->execute();
            return true; // Actualización exitosa
        } catch (PDOException $e) {
            return ("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function deleteProductPedido()
    {
        try {
            $id = $_POST['id'];
            $conexion = parent::Conexion();
            $sql = "DELETE FROM alertaspedido WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return ("Error al eliminar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function getProductPedido()
    {
        try {
            $conexion = parent::Conexion();
            $conexion->beginTransaction();
            $sql = "SELECT i.id_color,i.id_talla,ap.*,ap.est as est_ap,ap.id as id_pedido,ap.descripcion as descripcion_ap,pr.nombre as prov_nombre,pr.telefono,t.*,c.*,p.*,ip.* 
            FROM alertaspedido ap
            INNER JOIN inventario i ON i.id=ap.id_inventario
            INNER JOIN tallas t ON t.id=i.id_talla
            INNER JOIN colores c ON c.id=i.id_color
            INNER JOIN productos p ON p.id=i.id_producto
            INNER JOIN proveedores pr ON pr.id=ap.id_proveedor 
            LEFT JOIN imagenes_producto ip ON ip.id_producto=p.id
            WHERE ip.orden=1 ORDER BY ap.fecha DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }
}
