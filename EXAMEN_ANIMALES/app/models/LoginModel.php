<?php

namespace Ezequiel\App\models;

use Ezequiel\Lib\Database;

class LoginModel
{
    private $db; // La instancia de la clase Database
    // private $conn;
    public function __construct()
    {
        $this->db = new Database();
    }
    //implementar todas las funciones necesarias
    public function getUsuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $data = $this->db->executeQuery($sql, [$usuario]);

        if (empty($data)) {
            return false;
        }

        return $data[0];
    }
}
