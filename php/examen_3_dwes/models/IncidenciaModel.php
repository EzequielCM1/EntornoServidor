<?php

require_once APP_ROOT . '/includes/Database.php';

class IncidenciaModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM incidencias";
        return $this->db->executeQuery($sql);
    }
    public function buscarId($id)
    {
        $sql = "SELECT * FROM incidencias WHERE id = ?";
        return $this->db->executeQuery($sql, [$id]);
    }
    public function recogerEstado($id){
        $sql = "SELECT estado FROM incidencias WHERE id = ? ";
        return $this->db->executeQuery($sql, [$id]);
    }
    public function cambiarEstado($id, $estado){
        $sql = "UPDATE incidencias 
            SET estado = ?
            WHERE id = ?";
        return $this->db->executeUpdate($sql, [$estado, $id]);
    }
     public function borrarIncidencia($id)
    {
        $sql = "DELETE FROM incidencias where id = ?";
        return $this->db->executeUpdate($sql, [$id]);
    }
    public function crearIncidencia($asunto, $tipo, $hora)// no pongo el estado en pendiente porque ya lo hace la base de datos
    {
        $sql = "INSERT INTO incidencias (asunto, tipo_incidencia, horas_estimadas) VALUES (?, ?, ?)";
        return $this->db->executeUpdate($sql, [$asunto, $tipo, $hora]);
    }
}
