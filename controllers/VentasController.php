<?php
require_once '../models/VentaModel.php';

class VentasController
{

    public function getEstadistica()
    {
        $model = new VentaModel();
        $data = $model->getEstadisticas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }


    public function getDetalleVentas()
    {
        $model = new VentaModel();
        $data = $model->getDetalleVentas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }



    public function getVentas()
    {
        $ventaModel = new VentaModel();
        $ventas = $ventaModel->getVentas();
        echo json_encode($ventas);
    }

    public function getAllVentas()
    {
        $ventaModel = new VentaModel();
        $ventas = $ventaModel->getAllVentas();
        echo json_encode($ventas);
    }
 

    public function insertVentaClient($productos)
    {
        try {
            $model = new VentaModel();
            $data = $model->insertVentaClient($productos);
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
    public function updateVenta()
    {
        try {
            $model = new VentaModel();
            $data = $model->updateVenta();

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
    public function deleteVenta()
    {
        try {
            $model = new VentaModel();
            $data = $model->deleteVenta();

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
    public function getReporteVentas()
    {
        try {
            $model = new VentaModel();
            $data = $model->getReporteVentas();

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
    public function getClienteVenta()
    {
        try {
            session_start();
            $id = $_GET['id'];
            $model = new VentaModel();
            $data = $model->getClienteVenta($id);

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al obtener los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    public function getProductsVentaAdmin()
    {
        try {
            $model = new VentaModel();
            $data = $model->getProductsVentaAdmin($_GET['id']);

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al obtener los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    
    
    public function getProductsCliente()
    {
        try {
            $model = new VentaModel();
            $data = $model->getProductsCliente();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al obtener los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
