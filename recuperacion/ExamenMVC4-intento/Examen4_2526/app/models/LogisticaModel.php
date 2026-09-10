<?php
namespace Ezequiel\App\models;
use Ezequiel\Lib\Database;

class LogisticaModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM vehiculos";
        return $this->db->executeQuery($sql);
    }

    public function getVehiculo($id)
    {
        $sql = "SELECT id, nombre, matricula, carga_maxima, volumen_maximo, imagen, estado FROM vehiculos WHERE id = ? AND estado = 'Disponible'";
        $result = $this->db->executeQuery($sql, [$id]);
        return count($result) > 0 ? $result[0] : [];
    }

    public function getPaquetes()
    {
        $sql = "SELECT codigo, destino, peso, volumen, prioridad, estado FROM paquetes WHERE estado = 'Pendiente' ORDER BY prioridad, peso DESC";
        return $this->db->executeQuery($sql);
    }
}