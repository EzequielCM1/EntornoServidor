<?php

namespace Ezequiel\App\models;

use Ezequiel\Lib\Database;

class RefugioModel
{
    private $db; // La instancia de la clase Database
    // private $conn;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAnimales()
    {
        //implementar esta función.
        //hacer uso de la clase Database cuando sea necesario
        $sql = "SELECT * FROM animales";
        $data = $this->db->executeQuery($sql, []);
        return $data;

        // esto para cuando quieres sacar los datos del animal pero comprobando que no sea null
        //$sql = "SELECT * FROM animales WHERE id = ?";
        //$data = $this->db->executeQuery($sql, [$id]);
        // return $data[0] ?? null;
    }
}
