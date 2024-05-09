<?php
session_start();
class Conectar
{
    protected $dbh;

    protected function Conexion()
    {
        $dsn = "mysql:host=localhost;dbname=u823153798_ecomerce1;charset=utf8";

        $credentials = [
            ["username" => "u823153798_dark", "password" => "QPiRidRPi|0"],
            ["username" => "root", "password" => "123456"],
            ["username" => "dark", "password" => "12345"],
            ["username" => "root", "password" => ""]
        ];

        foreach ($credentials as $credential) {
            try {
                $this->dbh = new PDO($dsn, $credential['username'], $credential['password']);
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->set_names();
                return $this->dbh;
            } catch (PDOException $e) {
            }
        }
        die("No se pudo establecer conexión con la base de datos.");
    }

    public function set_names()
    {
        try {
            $this->dbh->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            die("¡Error al establecer el conjunto de caracteres!: " . $e->getMessage());
        }
    }
    public static function ruta()
    {
        return "https://asotaeco.com";
    }
}
