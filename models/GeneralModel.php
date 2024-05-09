<?php
require_once '../config/Conectar.php';

class GeneralModel extends Conectar
{
    public function getAllTallas()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM tallas";
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
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM colores";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getAllOcasion()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM ocasion";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getAllTprenda()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM tipo_prenda";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getAllGeneros()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM genero";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function updateTalla()
    {
        try {
            $id = $_POST["id"];
            $nombre = $_POST["talla"];
            $desc_talla = $_POST["desc_talla"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $sql = "UPDATE tallas SET talla=?, desc_talla=?, est=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $desc_talla);
            $stmt->bindValue(3, $est);
            $stmt->bindValue(4, $id);
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

    public function deleteTalla()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE tallas SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertTalla()
    {
        try {
            $nombre = $_POST["talla"];
            $desc = $_POST["desc_talla"];

            $conexion = parent::Conexion();
            $sql = "INSERT INTO tallas (talla, desc_talla,est) VALUES (?, ?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $desc);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    public function updateGenero()
    {
        try {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $sql = "UPDATE genero SET nombre=?, est=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $est);
            $stmt->bindValue(3, $id);
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

    public function deleteGenero()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE genero SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertGenero()
    {
        try {
            $nombre = $_POST["nombre"];
            $conexion = parent::Conexion();
            $sql = "INSERT INTO genero (nombre,est) VALUES (?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    //
    public function updateOcasion()
    {
        try {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $sql = "UPDATE ocasion SET nombre=?, est=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $est);
            $stmt->bindValue(3, $id);
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

    public function deleteOcasion()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE ocasion SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertOcasion()
    {
        try {
            $nombre = $_POST["nombre"];
            $conexion = parent::Conexion();
            $sql = "INSERT INTO ocasion (nombre,est) VALUES (?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    //
    public function updateTprenda()
    {
        try {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $sql = "UPDATE tipo_prenda SET nombre=?, est=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $est);
            $stmt->bindValue(3, $id);
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

    public function deleteTprenda()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE tipo_prenda SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertTprenda()
    {
        try {
            $nombre = $_POST["nombre"];
            $conexion = parent::Conexion();
            $sql = "INSERT INTO tipo_prenda (nombre,est) VALUES (?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    //
    public function updateColor()
    {
        try {
            $id = $_POST["id"];
            $color = $_POST["color"];
            $color_hexa = $_POST["color_hexa"];
            $est = $_POST["est"];
            $conexion = parent::Conexion();
            $sql = "UPDATE colores SET color=?,color_hexa=?, est=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $color);
            $stmt->bindValue(2, $color_hexa);
            $stmt->bindValue(3, $est);
            $stmt->bindValue(4, $id);
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

    public function deleteColor()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE colores SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertColor()
    {
        try {
            $color = $_POST["color"];
            $color_hexa = $_POST["color_hexa"];
            $conexion = parent::Conexion();
            $sql = "INSERT INTO colores (color,color_hexa,est) VALUES (?,?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $color);
            $stmt->bindValue(2, $color_hexa);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
    public function getWishClient()
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];
            $conexion = parent::Conexion();
            $sqlProducto = "SELECT w.id as id_fav,w.*,p.*,ip.* FROM wish_list w
                INNER JOIN productos p ON w.id_producto=p.id
                INNER JOIN imagenes_producto ip ON ip.id_producto=p.id
                 WHERE w.id_usuario=? AND ip.orden=1";
            $stmt = $conexion->prepare($sqlProducto);
            $stmt->bindValue(1, $id_user);
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


    public function deleteWishClient()
    {
        try {
            $conexion = parent::Conexion();
            $conexion->beginTransaction();
            $id =  $_POST['id'];
            $sqlDelete = "DELETE FROM wish_list WHERE id = ?";
            $stmt = $conexion->prepare($sqlDelete);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $conexion->commit();

            return true;
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error al eliminar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            return ("Error: " . $e->getMessage());
        }
    }
}
