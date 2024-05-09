<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class CompraModel extends Conectar
{
    public function getEstadisticas()
    {
        try {
            // Obtener la conexión usando parent::Conexion()
            $conexion = parent::Conexion();

            // Consulta para obtener el número de compras de la última semana
            $queryNumCompras = "SELECT COUNT(id) AS num from compras where fecha BETWEEN DATE( DATE_SUB(NOW(),INTERVAL 7 DAY) ) AND NOW();";
            $stmtNumCompras = $conexion->prepare($queryNumCompras);
            $stmtNumCompras->execute();
            $rowNumCompras = $stmtNumCompras->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener el número total de clientes
            $queryNumClientes = "SELECT COUNT(id) AS num from usuarios WHERE rol_id = 2;";
            $stmtNumClientes = $conexion->prepare($queryNumClientes);
            $stmtNumClientes->execute();
            $rowNumClientes = $stmtNumClientes->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener las compras por día
            $queryComprasDia = "SELECT SUM(detallecompras.subtotal) as total, DATE(compras.fecha) as fecha
                               FROM compras
                               INNER JOIN detallecompras ON detallecompras.idcompra = compras.id
                               GROUP BY DATE(compras.fecha);";
            $stmtComprasDia = $conexion->prepare($queryComprasDia);
            $stmtComprasDia->execute();
            $labelCompras = "";
            $datosCompras = "";

            while ($rowComprasDia = $stmtComprasDia->fetch(PDO::FETCH_ASSOC)) {
                $labelCompras .= "'" . $rowComprasDia['fecha'] . "',";
                $datosCompras .= $rowComprasDia['total'] . ",";
            }

            $labelCompras = rtrim($labelCompras, ",");
            $datosCompras = rtrim($datosCompras, ",");

            // Preparar los resultados para retornarlos
            $resultados = array(
                'numComprasSemana' => $rowNumCompras['num'],
                'numClientes' => $rowNumClientes['num'],
                'labelCompras' => $labelCompras,
                'datosCompras' => $datosCompras
            );

            return $resultados;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }






    public function getCompras()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario
FROM compras v
INNER JOIN recibe r ON v.id_recibe = r.id
INNER JOIN usuarios u ON v.id_client = u.id;
;
        
        WHERE est_pago=0;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            return ("Error al obtener compras: " . $e->getMessage());
        }
    }
    public function getAllCompras()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.id, v.fecha, v.total, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario,
            dv.id_variante_producto, dv.cantidad, dv.precio_unitario, dv.total_producto,
            p.nombre AS nombre_producto, p.descripcion AS descripcion_producto,
            g.nombre AS genero_producto, t.nombre AS tipo_prenda_producto,
            i.color, tll.talla, o.nombre AS ocasion_producto,
            ip.url_imagen AS imagen_producto
        FROM compras v
        INNER JOIN recibe r ON v.id_recibe = r.id
        INNER JOIN detalles_compra dv ON v.id = dv.id_compra
        INNER JOIN incomprario inv ON dv.id_variante_producto = inv.id
        INNER JOIN productos p ON inv.id_producto = p.id
        INNER JOIN genero g ON p.id_genero = g.id
        INNER JOIN tipo_prenda t ON p.id_tipo_prenda = t.id
        INNER JOIN colores i ON inv.id_color = i.id
        INNER JOIN tallas tll ON inv.id_talla = tll.id
        LEFT JOIN ocasion o ON p.id_ocasion = o.id
        LEFT JOIN imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1
        INNER JOIN usuarios u ON v.id_client = u.id;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            return ("Error al obtener compras: " . $e->getMessage());
        }
    }

    public function  getDetalleCompras()
    {
        $id = $_GET['id'];
        // $id = 3;
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT 
            dv.id, 
            dv.id_compra, 
            dv.cantidad, 
            dv.precio_unitario, 
            dv.total_producto,
            p.nombre AS nombre_producto,
            ip.url_imagen AS imagen,
            i.id_color,
            i.id_talla,
            c.color,
            t.talla
        FROM 
            detalles_compra dv
        JOIN 
            incomprario i ON dv.id_variante_producto = i.id
        JOIN 
            colores c ON i.id_color = c.id
        JOIN 
            tallas t ON i.id_talla = t.id
        JOIN 
            productos p ON i.id_producto = p.id
        LEFT JOIN 
            imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_compra=?;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            return ("Error al obtener compras: " . $e->getMessage());
        }
    }

    public function updateCompras()
    {
        try {
            $id = $_POST["id"];
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "UPDATE compras SET ruc=?, nombre=?, email=?, telefono=?, direccion=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $ruc);
            $stmt->bindValue(2, $nombre);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $telefono);
            $stmt->bindValue(5, $direccion);
            $stmt->bindValue(6, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido actualizar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function deleteCompras()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE compras SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del compra");
            }
        } catch (PDOException $e) {
            return ("Error al cambiar el estado del compra: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function insertCompras()
    {
        try {
            // Obtener el ID del usuario de la sesión
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];

            // Obtener los datos de la solicitud y decodificarlos
            $productos = json_decode($_POST["productos"], true);

            // Verificar si la decodificación fue exitosa
            if ($productos === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar los datos de los productos.");
            }

            // Tomar el total de compra del primer producto
            $totalCompra = $productos[0]["total"];

            $conexion = parent::Conexion();
            $conexion->beginTransaction(); // Iniciar una transacción

            // Insertar datos en la tabla compras
            $sqlCompra = "INSERT INTO compras (id_user, total, id_proveedor) VALUES (?, ?, ?)";
            $stmtCompra = $conexion->prepare($sqlCompra);
            $stmtCompra->bindValue(1, $id_user);
            $stmtCompra->bindValue(2, $totalCompra);
            $stmtCompra->bindValue(3, $productos[0]["id_proveedor"]);
            $stmtCompra->execute();

            // Obtener el ID de la compra insertada
            $idCompra = $conexion->lastInsertId();

            foreach ($productos as $producto) {
                $idProducto = $producto["id_producto"];
                $cantidad = $producto["stock"]; // Cantidad obtenida del stock
                $precioUnitario = $producto["precio"]; // Precio unitario obtenido del costo

                // Insertar datos en la tabla inventario
                $sqlInventario = "INSERT INTO inventario (id_producto, id_color, id_talla, stock, precio) VALUES (?, ?, ?, ?, ?)";
                $stmtInventario = $conexion->prepare($sqlInventario);
                $stmtInventario->bindValue(1, $idProducto);
                $stmtInventario->bindValue(2, $producto["id_color"]);
                $stmtInventario->bindValue(3, $producto["id_talla"]);
                $stmtInventario->bindValue(4, $cantidad);
                $stmtInventario->bindValue(5, $precioUnitario);
                $stmtInventario->execute();
                $idInventario = $conexion->lastInsertId();
                $costoUnitario = $producto["costo"];
                // Insertar datos en la tabla detalles_compra
                $sqlDetalleCompra = "INSERT INTO detalles_compra (id_compra, id_variante_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                $stmtDetalleCompra = $conexion->prepare($sqlDetalleCompra);
                $stmtDetalleCompra->bindValue(1, $idCompra);
                $stmtDetalleCompra->bindValue(2, $idInventario);
                $stmtDetalleCompra->bindValue(3, $cantidad);
                $stmtDetalleCompra->bindValue(4, $costoUnitario);
                $stmtDetalleCompra->execute();

                // Insertar producto proveedor
                $sqlProductoProveedor = "INSERT INTO productos_proveedores (id_producto, id_proveedor) VALUES (?, ?);";
                $stmtProductoProveedor = $conexion->prepare($sqlProductoProveedor);
                $stmtProductoProveedor->bindValue(1, $producto["id_producto"]);
                $stmtProductoProveedor->bindValue(2, $producto["id_proveedor"]);
                $stmtProductoProveedor->execute();
            }

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
}
