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
        $sql = "SELECT id, nombre, matricula, carga_maxima, volumen_maximo, combustible, km, imagen, estado FROM vehiculos";
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

    public function actualizarCarga($id_vehiculo, $codigos_paquetes)
    {
        if (empty($codigos_paquetes) || !$id_vehiculo) {
            return false;
        }

        $this->db->beginTransaction();

        // 1. Vehículo a 'En Ruta'
        $sqlV = "UPDATE vehiculos SET estado = 'En Ruta' WHERE id = ?";
        $update_vehiculo = $this->db->executeUpdate($sqlV, [$id_vehiculo]);

        // 2. Paquetes a 'En Transito'
        $placeholders = implode(',', array_fill(0, count($codigos_paquetes), '?'));
        $sqlP = "UPDATE paquetes SET estado = 'En Transito', vehiculo_id = ? WHERE codigo IN ($placeholders)";
        $params = array_merge([$id_vehiculo], $codigos_paquetes);
        $update_paquetes = $this->db->executeUpdate($sqlP, $params);

        if ($update_vehiculo === false || $update_paquetes === false) {
            $this->db->rollback();
            return false;
        } else {
            $this->db->commit();
            return true;
        }
    }
}
