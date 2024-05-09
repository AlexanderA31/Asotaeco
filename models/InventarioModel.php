<?php
require_once '../config/Conectar.php';

class InventarioModel extends Conectar
{
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
    public function getTallas()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT * FROM tallas WHERE est = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getTipoPrenda()
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
    public function getOcasion()
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

    public function getGenero()
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
    public function getCategorias()
    {
        $conexion = parent::Conexion();
        try {
            $sql = "SELECT id, nombre, 'Genero' AS tabla FROM genero
            UNION ALL
            SELECT id, nombre, 'Tipo Prenda' AS tabla FROM tipo_prenda
            UNION ALL
            SELECT id, nombre, 'Ocasion' AS tabla FROM ocasion;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }
}
