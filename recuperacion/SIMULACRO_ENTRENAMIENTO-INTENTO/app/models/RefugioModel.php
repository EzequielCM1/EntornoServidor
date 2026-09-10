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
    public function getAnimal($id){
        $sql = "SELECT * FROM animales where id = ?";
        $data = $this->db->executeQuery($sql, [$id]);
        return $data[0] ?? null;
    }

    public function registrar($datos)
    {
        $sql = "INSERT INTO animales (nombre, especie, raza, edad, peso, nivel_adiestramiento, puntos_expediente) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $datos['nombre'],
            $datos['especie'],
            $datos['raza'] ?? null,
            $datos['edad'] ?? 0,
            $datos['peso'] ?? 0.0,
            $datos['nivel_adiestramiento'] ?? 1,
            $datos['puntos_expediente'] ?? 0
        ];

        return $this->db->executeUpdate($sql, $params);
    }


    public function entrenar($id_animal, $id_usuario){
        if(!$id_animal || !$id_usuario) return false ;
        
        $animal = $this->getAnimal($id_animal);
        if(!$animal)return false;

        $this->db->beginTransaction();

        $nuevoAdiestramiento = min(10, $animal['nivel_adiestramiento']+1);
        $nuevosPuntos = min(100, $animal['puntos_expediente'] + 5);

        $sqlA = "UPDATE animales set nivel_adiestramiento = ?, puntos_expediente = ? WHERE id= ?";
        $update_animal = $this->db->executeUpdate($sqlA, [$nuevoAdiestramiento, $nuevosPuntos, $id_animal]);

        $sqlL = "INSERT INTO log_actividades (animal_id, usuario_id, accion) VALUES (?, ?, ?)";
        $update_log = $this->db->executeUpdate($sqlL, [$id_animal, $id_usuario, "Entrenamiento: +1 Nivel, +5 Puntos"]);

        if(!$update_animal || !$update_log){
            $this->db->rollback();
            return false;
        }else{
            $this->db->commit();
            return true;
        }
    }
}
