<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar
require_once '../models/CorreosModel.php';

class VentaModel extends Conectar
{
    public function getEstadisticas()
    {
        try {

            $resultados = array(
                'ventasMensuales' => $this->getVentasMensuales(),
                'ventasAnuales' => $this->getVentasAnuales(),
                'nuevosClientes' => $this->getNuevosClientes(),
            );
            return $resultados;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    private function getVentasMensuales()
    {
        try {
            $conexion = parent::Conexion();
            $queryVentasMensuales = "SELECT
            (SELECT MONTH(fecha) FROM ventas WHERE YEAR(fecha) = YEAR(NOW()) AND MONTH(fecha) = MONTH(NOW()) LIMIT 1) AS mes,
            COUNT(CASE WHEN YEAR(fecha) = YEAR(NOW()) AND MONTH(fecha) = MONTH(NOW()) THEN id END) AS ventasEsteMes,
            SUM(CASE WHEN YEAR(fecha) = YEAR(NOW()) AND MONTH(fecha) = MONTH(NOW()) THEN total ELSE 0 END) AS gananciasEsteMes,
            SUM(CASE WHEN YEAR(fecha) = YEAR(NOW()) AND MONTH(fecha) = MONTH(NOW()) - 1 THEN total ELSE 0 END) AS gananciasMesAnterior,
            COUNT(CASE WHEN YEAR(fecha) = YEAR(NOW()) AND MONTH(fecha) = MONTH(NOW()) - 1 THEN id END) AS ventasMesAnterior
        FROM ventas
        WHERE YEAR(fecha) = YEAR(NOW())
        AND (MONTH(fecha) = MONTH(NOW()) OR MONTH(fecha) = MONTH(NOW()) - 1)
        GROUP BY mes;";

            $stmtVentasMensuales = $conexion->prepare($queryVentasMensuales);
            $stmtVentasMensuales->execute();
            return $stmtVentasMensuales->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }


    private function getVentasAnuales()
    {
        try {
            $conexion = parent::Conexion();
            $queryVentasAnuales = "SELECT
                YEAR(fecha) AS anio,
                SUM(CASE WHEN YEAR(fecha) = YEAR(NOW()) THEN total ELSE 0 END) AS ventasAnioActual,
                SUM(CASE WHEN YEAR(fecha) = YEAR(NOW()) - 1 THEN total ELSE 0 END) AS ventasAnioAnterior
            FROM ventas
            GROUP BY YEAR(fecha);";

            $stmtVentasAnuales = $conexion->prepare($queryVentasAnuales);
            $stmtVentasAnuales->execute();
            return $stmtVentasAnuales->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    private function getNuevosClientes()
    {
        try {
            $conexion = parent::Conexion();
            $queryNuevosClientes = "SELECT
                (SELECT COUNT(id) FROM usuarios WHERE rol_id = 2 AND YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())) AS nuevosClientesEsteMes,
                (SELECT COUNT(id) FROM usuarios WHERE rol_id = 2 AND YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW()) - 1) AS nuevosClientesMesAnterior,
                (SELECT COUNT(id) FROM usuarios WHERE rol_id = 2 AND YEAR(created_at) = YEAR(NOW())) AS totalClientes;";

            $stmtNuevosClientes = $conexion->prepare($queryNuevosClientes);
            $stmtNuevosClientes->execute();
            $resultados = $stmtNuevosClientes->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getVentas()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario
FROM ventas v
INNER JOIN recibe r ON v.id_recibe = r.id
INNER JOIN usuarios u ON v.id_client = u.id
        
        WHERE est_pago!=2;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }
    public function getAllVentas()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.id, v.fecha, v.total, r.nombre AS nombre_recibe,r.*, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario,
            dv.id_variante_producto, dv.cantidad, dv.precio_unitario, dv.total_producto,
            p.nombre AS nombre_producto, p.descripcion AS descripcion_producto,
            g.nombre AS genero_producto, t.nombre AS tipo_prenda_producto,
            i.color, tll.talla, o.nombre AS ocasion_producto,
            ip.url_imagen AS imagen_producto
        FROM ventas v
        INNER JOIN recibe r ON v.id_recibe = r.id
        INNER JOIN detalles_venta dv ON v.id = dv.id_venta
        INNER JOIN inventario inv ON dv.id_variante_producto = inv.id
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
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }

    public function  getDetalleVentas()
    {
        $id = $_GET['id'];
        // $id = 3;
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT 
            dv.id, 
            dv.id_venta, 
            dv.cantidad, 
            dv.precio_unitario, 
                       p.nombre AS nombre_producto,
            ip.url_imagen AS imagen,
            i.id_color,
            i.id_talla,
            c.color,
            t.talla
        FROM 
            detalles_venta dv
        JOIN 
            inventario i ON dv.id_variante_producto = i.id
        JOIN 
            colores c ON i.id_color = c.id
        JOIN 
            tallas t ON i.id_talla = t.id
        JOIN 
            productos p ON i.id_producto = p.id
        LEFT JOIN 
            imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_venta=?;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }
    public function getReporteVentas()
    {
        $fecha_ini = $_GET['fecha_ini'];
        $fecha_fin = $_GET['fecha_fin'];
        $fechasV = false;
        if ($fecha_ini !== "null" && $fecha_fin !== "null") {
            $fechasV = true;
        }
        if ($fechasV) {
            $fecha_ini_mysql = $this->convertirFecha($fecha_ini);
            $fecha_fin_mysql = $this->convertirFecha($fecha_fin);
            if ($fecha_ini_mysql > $fecha_fin_mysql) {
                $temp = $fecha_ini_mysql;
                $fecha_ini_mysql = $fecha_fin_mysql;
                $fecha_fin_mysql = $temp;
            }
        }
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.*,r.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe, r.referencia AS referencia_recibe,
                u.nombre AS nombre_usuario
                FROM ventas v
                INNER JOIN recibe r ON v.id_recibe = r.id
                INNER JOIN usuarios u ON v.id_client = u.id
                WHERE DATE(v.fecha)";
            if ($fechasV) {
                $sql .= "  BETWEEN :fecha_ini AND :fecha_fin";
            }
            $stmt = $conexion->prepare($sql);
            if ($fechasV) {
                $stmt->bindParam(':fecha_ini', $fecha_ini_mysql);
                $stmt->bindParam(':fecha_fin', $fecha_fin_mysql);
            }
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }


    public function convertirFecha($fecha)
    {
        $partes = explode('/', $fecha);
        $fecha_convertida =  $partes[0] . '-' . $partes[1] . '-' . $partes[2];

        return $fecha_convertida;
    }

    public function updateVenta()
    {
        try {
            $id = $_POST["id"];
            $est = $_POST["est"];
            $guia = $_POST["guia_serv"];
            $conexion = parent::Conexion();
            $sql = "UPDATE ventas SET guia_servi=?, est_pago=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $guia);
            $stmt->bindValue(2, $est);
            $stmt->bindValue(3, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                http_response_code(400);
                throw new Exception("No se ha podido actualizar el registro ");
            }
        } catch (PDOException $e) {
            return ("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function deleteVenta()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE ventas SET est = CASE WHEN est_pago = 1 THEN 2 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del venta");
            }
        } catch (PDOException $e) {
            return ("Error al cambiar el estado del venta: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function getClienteVenta($id)
    {

        try {

            $conexion = parent::Conexion();
            $sql = "SELECT v.*,
            u.nombre as name_client,re.* 
     FROM ventas v
     INNER JOIN recibe re ON re.id = v.id_recibe
     INNER JOIN usuarios u ON u.id = v.id_client
     WHERE v.id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }

    public function getProductsVentaAdmin($id)
    {
        try {

            $conexion = parent::Conexion();
            $sql = "SELECT p.id as id_producto,
            t.talla,c.color,
            p.nombre AS producto, p.descripcion AS desc_producto, 
            SUM(dv.cantidad) AS cantidad, dv.precio_unitario as precio,
            iu.url_imagen AS imagen
     FROM  detalles_venta dv 
     INNER JOIN inventario ip ON dv.id_variante_producto = ip.id
     INNER JOIN tallas t ON t.id = ip.id_talla
     INNER JOIN colores c ON c.id = ip.id_color
     INNER JOIN productos p ON ip.id_producto = p.id
     LEFT JOIN imagenes_producto iu ON p.id = iu.id_producto AND iu.orden = 1
     WHERE dv.id_venta=? GROUP BY p.id, ip.id_color, ip.id_talla ;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }


    public function getProductsCliente()
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];
            //$id_user = 3;
            $est = $_GET['id'];

            $conexion = parent::Conexion();
            $sql = "SELECT p.id AS id_producto, v.guia_servi, v.id AS venta_id, v.est_pago, v.fecha AS fecha_venta, v.total AS total_venta, v.envio AS costo_envio,
            v.metodo_pago AS metodo_pago, v.ncomprobante AS numero_comprobante, v.comprobante AS comprobante_adjunto,
            p.nombre AS nombre_producto, p.descripcion AS descripcion_producto, 
            SUM(dv.cantidad) AS cantidad, dv.precio_unitario,
            iu.url_imagen AS imagen
     FROM ventas v
     INNER JOIN detalles_venta dv ON v.id = dv.id_venta
     INNER JOIN inventario ip ON dv.id_variante_producto = ip.id
     INNER JOIN productos p ON ip.id_producto = p.id
     LEFT JOIN imagenes_producto iu ON p.id = iu.id_producto AND iu.orden = 1
     WHERE v.id_client = ?";

            if ($est !== "null") {
                $sql .= " GROUP BY p.id, ip.id_color, ip.id_talla HAVING v.est_pago=? ORDER BY v.fecha DESC;";
            } else {
                $sql .= " GROUP BY p.id, ip.id_color, ip.id_talla ORDER BY v.fecha DESC;";
            }

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id_user);
            if ($est !== "null") {
                $stmt->bindValue(2, $est);
            }
            $stmt->execute();

            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            return ("Error al obtener ventas: " . $e->getMessage());
        }
    }




    public function insertVentaClient($productos)
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];

            //$id_user = 3;
            if ($productos === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar los datos de los productos.");
            }
            $cenvio = $_POST["cenvio"];
            $ci = $_POST["ci"];
            $isenvio = $_POST["isenvio"];
            $metodo_pago = $_POST["metodo_pago"];
            $ncomprobante = $_POST["ncomprobante"];

            $totalVenta = 0;
            foreach ($productos as $producto) {
                $totalVenta = $totalVenta + ($producto["cantidad"] * $producto["precio_venta"]);
            }
            $conexion = parent::Conexion();
            $conexion->beginTransaction();

            $nombre = $_POST["nombre"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];
            $provincia = $_POST["provincia"];
            $canton = $_POST["canton"];
            $direccion = $_POST["direccion"];
            $referencia = $_POST["referencia"];

            $sqlRecive = "INSERT INTO recibe (ci,nombre, telefono,email,provincia,canton,direccion,referencia,est) VALUES (?,?, ?,?,?,?,?,?,?)";
            $stmtRecibe = $conexion->prepare($sqlRecive);
            $stmtRecibe->bindValue(1, $ci);
            $stmtRecibe->bindValue(2, $nombre);
            $stmtRecibe->bindValue(3, $telefono);
            $stmtRecibe->bindValue(4, $email);
            $stmtRecibe->bindValue(5, $provincia);
            $stmtRecibe->bindValue(6, $canton);
            $stmtRecibe->bindValue(7, $direccion);
            $stmtRecibe->bindValue(8, $referencia);
            $stmtRecibe->bindValue(9, 1);
            $stmtRecibe->execute();

            $id_recibe = $conexion->lastInsertId();


            if (!empty($_FILES["comprobante"]["tmp_name"])) {

                $rutaImagenes = '../public/comprobantes/';
                $nombreImagen = uniqid();
                $nombreArchivo = $_FILES["comprobante"]["name"];
                $nombreArchivoDestino = $nombreImagen . '.webp';
                $rutaCompletaArchivo = $rutaImagenes . $nombreArchivoDestino;
                if (!move_uploaded_file($_FILES["comprobante"]["tmp_name"], $rutaCompletaArchivo)) {
                    throw new Exception("Error al mover la imagen a la carpeta de destino");
                }
                $url_imagen = "../../public/comprobantes/" . $nombreArchivoDestino;

                $sqlVenta = "INSERT INTO ventas (id_client,id_recibe,fecha, total, envio,isenvio,est_pago,metodo_pago,ncomprobante,comprobante) VALUES (?, ?, NOW(),?,?,?,?,?,?,?)";
                $stmtVenta = $conexion->prepare($sqlVenta);
                $stmtVenta->bindValue(1, $id_user);
                $stmtVenta->bindValue(2, $id_recibe);
                $stmtVenta->bindValue(3, $totalVenta);
                $stmtVenta->bindValue(4, $cenvio);
                $stmtVenta->bindValue(5, $isenvio);
                $stmtVenta->bindValue(6, 0);
                $stmtVenta->bindValue(7, $metodo_pago);
                $stmtVenta->bindValue(8, $ncomprobante);
                $stmtVenta->bindValue(9, $url_imagen);
                $stmtVenta->execute();
            } else {
                $sqlVenta = "INSERT INTO ventas (id_client,id_recibe,fecha, total, envio,isenvio,est_pago,metodo_pago,ncomprobante,comprobante) VALUES (?, ?, NOW(),?,?,?,?,?,?,?)";
                $stmtVenta = $conexion->prepare($sqlVenta);
                $stmtVenta->bindValue(1, $id_user);
                $stmtVenta->bindValue(2, $id_recibe);
                $stmtVenta->bindValue(3, $totalVenta);
                $stmtVenta->bindValue(4, $cenvio);
                $stmtVenta->bindValue(5, $isenvio);
                $stmtVenta->bindValue(6, 0);
                $stmtVenta->bindValue(7, $metodo_pago);
                $stmtVenta->bindValue(8, $ncomprobante);
                $stmtVenta->bindValue(9, "");
                $stmtVenta->execute();
            }

            $idVenta = $conexion->lastInsertId();

            foreach ($productos as $producto) {
                $idProducto = $producto["producto_id"];
                $idTalla = $producto["talla_id"];
                $idColor = $producto["color_id"];
                $precioUnitario = $producto["precio_venta"];
                $cantidadVendida = $producto["cantidad"];

                $sqlSelectInventario = "SELECT id, stock FROM inventario WHERE id_producto = ? AND id_talla=? AND id_color=?";
                $stmtSelectInventario = $conexion->prepare($sqlSelectInventario);
                $stmtSelectInventario->bindValue(1, $idProducto);
                $stmtSelectInventario->bindValue(2, $idTalla);
                $stmtSelectInventario->bindValue(3, $idColor);
                $stmtSelectInventario->execute();
                $inventarios = $stmtSelectInventario->fetchAll(PDO::FETCH_ASSOC);

                foreach ($inventarios as $inventario) {
                    $idInventario = $inventario["id"];
                    $stockDisponible = $inventario["stock"];
                    while ($cantidadVendida > 0 && $stockDisponible > 0) {
                        $cantidadADescontar = min($cantidadVendida, $stockDisponible);

                        $sqlActualizarInventario = "UPDATE inventario SET stock = stock - ? WHERE id = ?";
                        $stmtActualizarInventario = $conexion->prepare($sqlActualizarInventario);
                        $stmtActualizarInventario->bindValue(1, $cantidadADescontar);
                        $stmtActualizarInventario->bindValue(2, $idInventario);
                        $stmtActualizarInventario->execute();

                        $cantidadVendida -= $cantidadADescontar;
                        $stockDisponible -= $cantidadADescontar;
                        $sqlDetalleVenta = "INSERT INTO detalles_venta (id_venta, id_variante_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                        $stmtDetalleVenta = $conexion->prepare($sqlDetalleVenta);
                        $stmtDetalleVenta->bindValue(1, $idVenta);
                        $stmtDetalleVenta->bindValue(2, $idInventario);
                        $stmtDetalleVenta->bindValue(3, $cantidadADescontar);
                        $stmtDetalleVenta->bindValue(4, $precioUnitario);
                        $stmtDetalleVenta->execute();
                    }
                    if ($cantidadVendida <= 0) {
                        break;
                    }
                }
            }
            $res = $conexion->commit();
            $pdfModel = new PDFModel();
            $pdfModel->ventaPDF($idVenta, $email);
            return $res;
        } catch (PDOException $e) {
            $conexion->rollBack();
            return "Error al insertar los datos: " . $e->getMessage();
        } catch (Exception $e) {
            $conexion->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
}
