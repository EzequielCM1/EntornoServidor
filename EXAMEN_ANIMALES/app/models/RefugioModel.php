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
    }
    public function getAnimal($id){
        $sql = "SELECT * FROM animales WHERE id= ?";
        $data = $this->db->executeQuery($sql, [$id]);
        return $data[0] ?? null;
        
    }
    public function getAnimalesRefugio(){
        $enrefugio = 1;
        $sql = "SELECT * FROM animales where en_refugio = ? ";
        $data = $this->db->executeQuery($sql, [$enrefugio]);
        return $data;
    }
    public function alimentar($energiaAmentada,$higeneReducido, $id){
        if(!$id) return false ;
        
        $animal = $this->getAnimal($id);
        if(!$animal)return false;

        $this->db->beginTransaction();
        $sqlA = "UPDATE animales set energia = ?, higiene = ? WHERE id= ?";
        $actualizarAnimal = $this->db->executeUpdate($sqlA, [$energiaAmentada, $higeneReducido, $id]);
        //hacemos rollback por si ocurre un error , con esto controlamos si supera el limite pero lo valido igualmente antes
        if(!$actualizarAnimal){
            $this->db->rollback();
            return false;
        }else{
            $this->db->commit();
            return true;
        }
    }
    public function limpiar($higieneAmentar,$energiaReducir, $id){
        if(!$id) return false ;
        
        $animal = $this->getAnimal($id);
        if(!$animal)return false;

        $this->db->beginTransaction();
        $sqlA = "UPDATE animales set energia = ?, higiene = ? WHERE id= ?";
        $actualizarAnimal = $this->db->executeUpdate($sqlA, [$energiaReducir, $higieneAmentar, $id]);
        //hacemos rollback por si ocurre un error , con esto controlamos si supera el limite pero lo valido igualmente antes
        if(!$actualizarAnimal){
            $this->db->rollback();
            return false;
        }else{
            $this->db->commit();
            return true;
        }
    }
    public function dormir(){

    }

    public function adopcion($id, $usuario){
        $nuevoEstado = 0;
        $animal = $this->getAnimal($id);
        if(!$animal)return false;
        $this->db->beginTransaction();
        $sqlA = "UPDATE animales set en_refugio = ? WHERE id= ?";
        $adotar = $this->db->executeUpdate($sqlA, [$nuevoEstado, $id]);

// INSERT INTO adopciones
// (`id`,
// `animal_id`,
// `nombre_animal`,
// `especie`,
// `edad_adopcion`,
// `peso_adopcion`,
// `energia_final`,
// `higiene_final`,
// `fecha_adopcion`,
// `usuario_id`)
// VALUES (?, ?, ? )

//         $sqlL = "INSERT INTO  () VALUES (?, ?, ?)";
//         $update_log = $this->db->executeUpdate($sqlL, [$]);


        if(!$adotar){
            $this->db->rollback();
            return false;
        }else{
            $this->db->commit();
            return true;
        }
    }
}
