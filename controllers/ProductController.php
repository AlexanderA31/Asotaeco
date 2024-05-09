<?php
require_once '../models/ProductModel.php';

class ProductController
{

    public function insertProduct()
    {
        $model = new ProductModel();
        $data = $model->insertProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function updateProduct()
    {
        $model = new ProductModel();
        $data = $model->updateProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function deleteProduct()
    {
        $model = new ProductModel();
        $data = $model->deleteProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function downloadStock()
    {
        $model1 = new ProductModel();
        $model = new DownloadPDF();
        $id = $_GET['id'];
        $data = $model->downloadStock($model1->getAllProductsStock($id));
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getAllProducts()
    {
        $model = new ProductModel();
        $data = $model->getAllProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getAllProductsStock()
    {
        $model = new ProductModel();
        $data = $model->getAllProductsStock();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProducts()
    {
        $model = new ProductModel();
        $data = $model->getProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProductsShop()
    {
        $model = new ProductModel();
        $data = $model->getProductsShop();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getPrecioShop()
    {
        $model = new ProductModel();
        $data = $model->getPrecioShop();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProductsAlert()
    {
        $model = new ProductModel();
        $data = $model->getProductsAlert();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProductDetail()
    {
        $model = new ProductModel();
        $data = $model->getProductDetail();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function setProductPedido($products)
    {
        $model = new ProductModel();
        $data = $model->setProductPedido($products);
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProductPedido()
    {
        $model = new ProductModel();
        $data = $model->getProductPedido();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function updateProductPedido()
    {
        $model = new ProductModel();
        $data = $model->updateProductPedido();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function deleteProductPedido()
    {
        $model = new ProductModel();
        $data = $model->deleteProductPedido();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getWishList()
    {
        $model = new ProductModel();
        $data = $model->getWishList();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }

    public function getImgProd()
    {
        $model = new ProductModel();
        $data = $model->getImgProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getAllImgProd()
    {
        $model = new ProductModel();
        $data = $model->getAllImgProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getColoresTalla()
    {
        $model = new ProductModel();
        $data = $model->getColoresTalla();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getTallasColor()
    {
        $model = new ProductModel();
        $data = $model->getTallasColor();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }

    public function insertImgsProduct()
    {
        $model = new ProductModel();
        $data = $model->insertImgsProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function updateImgsProduct()
    {
        $model = new ProductModel();
        $data = $model->updateImgsProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function deleteImgProduct()
    {
        $model = new ProductModel();
        $data = $model->deleteImgProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function estImgProduct()
    {
        $model = new ProductModel();
        $data = $model->estImgProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getImagesProducts()
    {
        $model = new ProductModel();
        $data = $model->getImagesProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getProductsRecent()
    {
        try {
            $model = new ProductModel();
            $data = $model->getProductsRecent();
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
    
}
