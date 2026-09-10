<?php

/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\App\models;

use Pepelluyot\Lib\Database;

class LogisticaModel
{
    private $db; // La instancia de la clase Database
    private $conn;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function getVehiculos() //obtiene todos los vehiculos operarivos
    {
        // 1. Preparamos la consulta: buscamos al usuario por su nombre
        $sql = "select id, nombre, matricula, carga_maxima, volumen_maximo, combustible, km, imagen, estado from vehiculos;";
        //  where estado = 'Disponible';";

        $result = $this->db->executeQuery($sql);

        // Si devuelve registros
        if (count($result) == 0) {
            return [];
        }
        return $result;
    }
    public function getVehiculo($id) //obtiene todos los vehiculos operarivos
    {
        // 1. Preparamos la consulta: buscamos al usuario por su nombre
        $sql = "select id, nombre, matricula, carga_maxima, volumen_maximo, imagen, estado from vehiculos
        where estado = 'Disponible' and id=?;";
        //  where estado = 'Disponible';";

        $result = $this->db->executeQuery($sql, [$id]);

        // Si devuelve registros
        if (count($result) == 0) {
            return [];
        }
        return $result[0];
    }
    public function getPaquetes() //obtiene todos los paquetes en estado disponibles
    {
        // 1. Preparamos la consulta: buscamos al usuario por su nombre
        $sql = "select codigo, destino, peso, volumen, prioridad, estado, vehiculo_id from paquetes where estado = 'Pendiente' order by prioridad, peso desc";

        $result = $this->db->executeQuery($sql);

        // Si devuelve registros
        if (count($result) == 0) {
            return [];
        }
        return $result;
    }

    public function actualizarCarga($id_vehiculo, $codigos_paquetes)
    {
        if (count($codigos_paquetes) == 0 || !$id_vehiculo) {
            return false;
        }
        //iniciamos una transacción
        $this->db->beginTransaction();
        // 1. Vehículo a 'En Ruta'
        $sqlV = "UPDATE vehiculos SET estado = 'En Ruta' WHERE id = ?";
        $update_vehiculo = $this->db->executeUpdate($sqlV, [$id_vehiculo]);
        // 2. Paquetes a 'En Transito'
        $placeholders = implode(',', array_fill(0, count($codigos_paquetes), '?'));
        $sqlP = "UPDATE paquetes SET estado = 'En Transito', vehiculo_id = ? WHERE codigo IN ($placeholders)";
        $params = array_merge([$id_vehiculo], $codigos_paquetes);
        $update_paquetes = $this->db->executeUpdate($sqlP, $params);
        if (!$update_vehiculo || !$update_paquetes) {
            $this->db->rollback();
            return false;
        } else {
            $this->db->commit();
            return true;
        }
    }
}
