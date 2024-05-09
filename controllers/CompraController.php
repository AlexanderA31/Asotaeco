<?php
require_once '../models/CompraModel.php';

class ComprasController
{

    public function getEstadistica()
    {
        $model = new CompraModel();
        $data = $model->getEstadisticas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
 

    public function getDetalleCompras()
    {
        $model = new CompraModel();
        $data = $model->getDetalleCompras();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
  


    public function getCompras()
    {
        $compraModel = new CompraModel();
        $compras = $compraModel->getCompras();
        echo json_encode($compras);
    }

    public function getAllCompras()
    {
        $compraModel = new CompraModel();
        $compras = $compraModel->getAllCompras();
        echo json_encode($compras);
    }
    public function updateCompras()
    {
        try {
            $model = new CompraModel();
            $data = $model->updateCompras();
            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al actualizar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
 
    public function deleteCompras()
    {
        try {
            $model = new CompraModel();
            $data = $model->deleteCompras();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al eliminar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }

    public function insertCompras()
    {
        try {
            $model = new CompraModel();
            $data = $model->insertCompras();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
