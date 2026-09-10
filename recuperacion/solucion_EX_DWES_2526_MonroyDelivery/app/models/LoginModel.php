<?php
/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\App\models;
use Pepelluyot\Lib\Database;

class LoginModel
{
    private $db; // La instancia de la clase Database
    // private $conn;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function buscarEmpleadoPorCodigo($codigo)
    {
        // 1. Preparamos la consulta: buscamos al usuario por su nombre
        $sql ="SELECT id, id_empleado, nombre, apellidos, pin, rol FROM empleados WHERE id_empleado = ?;";

        
        // 2. Le pasamos el nombre de usuario y obtenemos los resultados
        $resultado = $this->db->executeQuery($sql, [$codigo]);

        // Si no existe el usuario → falso
        return $resultado ? $resultado[0] : [];
        
    }
}
