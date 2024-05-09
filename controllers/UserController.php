<?php
require_once '../models/UserModel.php';
//require_once '../models/CorreosModel.php';
class UserController
{
    public function getUsers()
    {
        $userModel = new UserModel();
        $data = $userModel->getAllUsers();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getAllClients()
    {
        $model = new UserModel();
        $data = $model->getAllClients();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function resetPassClient()
    {
        $model = new UserModel();
        $data = $model->resetPassClient();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }

    public function getAllEmpresa()
    {
        $model = new UserModel();
        $data = $model->getAllEmpresa();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getUserData()
    {
        $userModel = new UserModel();
        $data = $userModel->getUserData();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function getAllUsers()
    {
        $userModel = new UserModel();
        $data = $userModel->getAllUsers();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
            http_response_code(200);
        }
    }
    public function updateUsers()
    {
        try {
            $model = new UserModel();
            $data = $model->updateUsers();
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

    public function deleteUsers()
    {
        try {
            $model = new UserModel();
            $data = $model->deleteUsers();

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
    public function cambiarPass()
    {
        try {
            $id_user = $_POST['id_user'];
            $pass = $_POST['pass'];
            $model = new UserModel();
            $data = $model->actualizarPassword($id_user, $model->encriptarPassword($pass));

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



    public function registrar()
    {
        $userModel = new UserModel();
        $data = $userModel->registrarUsuario();
        echo json_encode($data);
    }
    public function login()
    {
        try {
            $userModel = new UserModel();
            $userData = $userModel->login();

            if ($userData) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_session'] = $userData;
                http_response_code(200);
                echo json_encode($userData);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Inicio de sesión fallido'));
            }
        } catch (Exception $e) {
            // Enviar una respuesta de error en caso de excepción con código HTTP 400
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
