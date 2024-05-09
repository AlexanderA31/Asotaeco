<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class PublicidadModel extends Conectar
{
    public function getAllSliders()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT * FROM sliders";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }



    public function getSliders()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT * FROM sliders WHERE est=1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function updateSliders()
    {
        try {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $descripcion = $_POST["descripcion"];

            // Actualizar los datos en la base de datos
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "UPDATE sliders SET titulo=?, descripcion=?, img=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $titulo);
            $stmt->bindValue(2, $descripcion);

            $rutaImagenes = '../public/images/sliders/';

            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES["img"]["name"])) {
                // Nombre único de la imagen
                $nombreImagen = uniqid(); // Sin extensión para la conversión a WebP

                // Mover la nueva imagen a la carpeta deseada
                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $rutaImagenes . $nombreImagen . '.webp')) {
                    throw new Exception("Error al mover la nueva imagen a la carpeta de destino");
                }

                // Obtener la imagen actual del registro
                $stmt_img = $conexion->prepare("SELECT img FROM sliders WHERE id=?");
                $stmt_img->execute([$id]);
                $imagenActual = $stmt_img->fetchColumn();

                // Eliminar la imagen actual si existe
                if ($imagenActual && file_exists($imagenActual)) {
                    unlink($imagenActual);
                }

                // Asignar la ruta de la nueva imagen en formato WebP al statement
                $stmt->bindValue(3, "../../public/images/sliders/" . $nombreImagen . '.webp');
            } else {
                // No se cargó una nueva imagen, mantener la imagen existente
                $stmt_img = $conexion->prepare("SELECT img FROM sliders WHERE id=?");
                $stmt_img->execute([$id]);
                $imagenActual = $stmt_img->fetchColumn();
                $stmt->bindValue(3, $imagenActual);
            }

            $stmt->bindValue(4, $id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se ha actualizado el registro correctamente
            if ($stmt->rowCount() > 0) {
                return true; // Se ha actualizado correctamente
            } else {
                throw new Exception("No se ha podido actualizar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }

    public function insertSliders()
    {
        try {
            // Obtener los datos enviados por el formulario
            $titulo = $_POST["titulo"];
            $descripcion = $_POST["descripcion"];

            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "INSERT INTO sliders (titulo, descripcion, img, url_web) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $titulo);
            $stmt->bindValue(2, $descripcion);

            $rutaImagenes = '../public/images/sliders/';
            if (!empty($_FILES["img"]["name"])) {
                $nombreImagen = uniqid();
                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $rutaImagenes . $nombreImagen . '.webp')) {
                    throw new Exception("Error al mover la imagen a la carpeta de destino");
                }

                $stmt->bindValue(3, "../../public/images/sliders/" . $nombreImagen . '.webp');
            } else {
                $stmt->bindValue(3, "");
            }

            $stmt->bindValue(4, ""); 
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

    public function deleteSliders()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $stmt_img = $conexion->prepare("SELECT img FROM sliders WHERE id=?");
            $stmt_img->execute([$id]);
            $imagenActual = $stmt_img->fetchColumn();
            if ($imagenActual && file_exists($imagenActual)) {
                unlink($imagenActual);
            }
            $sql = "DELETE FROM sliders WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true; // El registro se ha eliminado correctamente
            } else {
                throw new Exception("No se ha podido eliminar el registro");
            }
        } catch (PDOException $e) {
            return ("Error al eliminar el registro: " . $e->getMessage());
        } catch (Exception $e) {
            return ("Error: " . $e->getMessage());
        }
    }
}
