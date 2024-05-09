<?php
require_once '../models/ProveedorModel.php';

class ProveedorController
{
    public function getProveedores()
    {
        $proveedorModel = new ProveedorModel();
        $proveedores = $proveedorModel->getAllProveedores();
        echo json_encode($proveedores);
    }
    public function getAllProveedores()
    {
        $proveedorModel = new ProveedorModel();
        $proveedores = $proveedorModel->getAllProveedores();
        echo json_encode($proveedores);
    }
    public function updateProveedores()
    {
        try {
            $model = new ProveedorModel();
            $data = $model->updateProveedores();
            if ($data) {
                http_response_code(200);
                echo json_encode($data);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al actualizar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
 
    public function deleteProveedores()
    {
        try {
            $model = new ProveedorModel();
            $data = $model->deleteProveedores();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al eliminar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }

    public function insertProveedores()
    {
        try {
            $model = new ProveedorModel();
            $data = $model->insertProveedores();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }

}
