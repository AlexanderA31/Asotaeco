<?php
require_once '../config/Conectar.php';

class ProveedorModel extends Conectar
{
    public function getAllProveedores()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM proveedores";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $proveedores;
        } catch (PDOException $e) {
            return ("Error al obtener proveedores: " . $e->getMessage());
        }
    }
    public function getProveedores()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM proveedores WHERE est=1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $proveedores;
        } catch (PDOException $e) {
            return ("Error al obtener proveedores: " . $e->getMessage());
        }
    }
    public function updateProveedores()
    {
        try {
            $id = $_POST["id"];
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "UPDATE proveedores SET ruc=?, nombre=?, email=?, telefono=?, direccion=? WHERE id=?";
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

    public function deleteProveedores()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE proveedores SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
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

    public function insertProveedores()
    {
        try {
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "INSERT INTO proveedores (ruc, nombre, email, telefono, direccion, est) VALUES (?, ?, ?, ?, ?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $ruc);
            $stmt->bindValue(2, $nombre);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $telefono);
            $stmt->bindValue(5, $direccion);
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
}
