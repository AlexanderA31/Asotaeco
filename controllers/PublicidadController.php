<?php
require_once '../models/PublicidadModel.php';

class PublicidadController
{


    public function getAllSliders()
    {
        try {
            $model = new PublicidadModel();
            $data = $model->getAllSliders();

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
    public function getSliders()
    {
        // Obtener datos desde el modelo
        $model = new PublicidadModel();
        $data = $model->getSliders();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function updateSliders()
    {
        try {
            $model = new PublicidadModel();
            $data = $model->updateSliders();
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
    public function insertSliders()
    {
        try {
            $model = new PublicidadModel();
            $data = $model->insertSliders();

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
    public function deleteSliders()
    {
        try {
            $model = new PublicidadModel();
            $data = $model->deleteSliders();

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
