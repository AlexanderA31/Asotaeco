<?php
require_once '../models/InventarioModel.php';
require_once '../models/DownloadPDF.php';
require_once '../models/PDFModel.php';
require_once '../models/ProductModel.php';
require_once '../models/GeneralModel.php';
require_once '../models/CorreosModel.php';
class Controller
{

    public function getTallas()
    {
        $model = new InventarioModel();
        $data = $model->getTallas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllTallas()
    {
        $model = new GeneralModel();
        $data = $model->getAllTallas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getColores()
    {
        $model = new InventarioModel();
        $data = $model->getColores();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllColores()
    {
        $model = new InventarioModel();
        $data = $model->getAllColores();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getOcasion()
    {
        $model = new InventarioModel();
        $data = $model->getOcasion();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllOcasion()
    {
        $model = new GeneralModel();
        $data = $model->getAllOcasion();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getTipoPrenda()
    {
        $model = new InventarioModel();
        $data = $model->getTipoPrenda();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllTprenda()
    {
        $model = new GeneralModel();
        $data = $model->getAllTprenda();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getGenero()
    {
        $model = new InventarioModel();
        $data = $model->getGenero();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllGeneros()
    {
        $model = new GeneralModel();
        $data = $model->getAllGeneros();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }



    public function getCategorias()
    {
        $model = new InventarioModel();
        $data = $model->getCategorias();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function insertWishClient()
    {
        try {
            $model = new ProductModel();
            $data = $model->insertWishClient();

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
    public function getWishClient()
    {
        try {
            $model = new GeneralModel();
            $data = $model->getWishClient();

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

    public function getPDFHTML()
    {
        $model = new DownloadPDF();
        $data = $model->getPDFHTML();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function sendEmail()
    {
        $model = new CorreosModel();
        $data = $model->enviarCorreo();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function deleteWishClient()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteWishClient();

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
    public function getVentaUser()
    {
        try {
            $model = new PDFModel();
            $data = $model->getVentaUser();
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


    public function updateTalla()
    {
        try {
            $model = new GeneralModel();
            $data = $model->updateTalla();
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

    public function deleteTalla()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteTalla();

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

    public function insertTalla()
    {
        try {
            $model = new GeneralModel();
            $data = $model->insertTalla();

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

    public function updateOcasion()
    {
        try {
            $model = new GeneralModel();
            $data = $model->updateOcasion();
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

    public function deleteOcasion()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteOcasion();

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

    public function insertOcasion()
    {
        try {
            $model = new GeneralModel();
            $data = $model->insertOcasion();

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
    public function updateGenero()
    {
        try {
            $model = new GeneralModel();
            $data = $model->updateGenero();
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

    public function deleteGenero()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteGenero();

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

    public function insertGenero()
    {
        try {
            $model = new GeneralModel();
            $data = $model->insertGenero();

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

    public function updateColor()
    {
        try {
            $model = new GeneralModel();
            $data = $model->updateColor();
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

    public function deleteColor()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteColor();

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

    public function insertColor()
    {
        try {
            $model = new GeneralModel();
            $data = $model->insertColor();

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
    public function updateTprenda()
    {
        try {
            $model = new GeneralModel();
            $data = $model->updateTprenda();
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

    public function deleteTprenda()
    {
        try {
            $model = new GeneralModel();
            $data = $model->deleteTprenda();

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

    public function insertTprenda()
    {
        try {
            $model = new GeneralModel();
            $data = $model->insertTprenda();

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
