<?php
require_once '../models/CantonesModel.php';
class CantonesController
{
    public function getCantonsByProvince()
    {
        try {
            $model = new CantonesModel();
            $data = $model->getCantonsByProvince($_GET['provincia']);
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
    public function getProvincias()
    {
        try {
            $model = new CantonesModel();
            $data = $model->getAllProvinces();
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
}
