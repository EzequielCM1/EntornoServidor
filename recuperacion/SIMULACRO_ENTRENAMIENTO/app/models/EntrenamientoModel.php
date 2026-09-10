<?php

namespace Ezequiel\App\models;

use Ezequiel\Lib\Database;

class EntrenamientoModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAnimalesSanos()
    {
        // TODO 11: Escribe la consulta SQL para obtener animales donde el estado sea 'Sano'
        $sql = "SELECT * FROM animales WHERE estado = 'Sano'";
        
        // TODO 12: Ejecuta la consulta (executeQuery) y devuelve el resultado.
        // Si no hay resultados, devuelve un array vacío [].
        $result = $this->db->executeQuery($sql, []);
        return $result;
    }

    public function registrarEntrenamiento($id_animal, $nivel)
    {
        if (!$id_animal || !$nivel) {
            return false;
        }

        // TODO 13: Iniciar la transacción con beginTransaction()
        $this->db->beginTransaction();

        // TODO 14: Actualizar el estado del animal a 'En Entrenamiento'
        // Usa: $this->db->executeUpdate("UPDATE ...", [$id_animal])
        $update = $this->db->executeUpdate("UPDATE animales SET estado = 'En Entrenamiento' WHERE id = ?", [$id_animal]);
        // TODO 15: Insertar en la tabla entrenamientos el id_animal y el nivel
        // Usa: $this->db->executeUpdate("INSERT INTO ...", [$id_animal, $nivel])
        $insert = $this->db->executeUpdate("INSERT INTO entrenamientos (id_animal, nivel) VALUES (?, ?)", [$id_animal, $nivel]);

        // TODO 16: Comprobar si **ambas** operaciones funcionaron.
        // Si funcionaron, hacer commit() y retornar true.
        // Si alguna falló, hacer rollback() y retornar false.
        if($update && $insert) {
            $this->db->commit();
            return true;
        }else{
            $this->db->rollback();
            return false;
        }
        
    }
}
