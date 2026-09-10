<?php
namespace Ezequiel\App\models;
use Ezequiel\Lib\Database;

class LoginModel{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
     public function buscarCodigoPin($codigo, $pin)
    {
        $sql = 'SELECT pin FROM empleados WHERE id_empleado = ?';
        $data = $this->db->executeQuery($sql, [$codigo]); // le metemos lso paramatros segun la sentencia en el array , por cada ? es un parametro en el array
        if (empty($data)) {
            return false;
        }
        //comprobar si devuelve datos $data[0]['password'] --> este es el password encriptado (hasheado)
        $passwordHash = $data[0]['pin'];
        //llammar password_verify($password, $passwdEncriptado) --> true/false
        if (password_verify($pin, $passwordHash)) {
            return true;  // login correcto
        } else {
            return false; // contraseña incorrecta
        }
        //return
    }
    public function recogerDatosUsuario($codigo){
        $sql = 'SELECT nombre, apellidos, rol from empleados where id_empleado = ?';
        // 2. Le pasamos el nombre de usuario y obtenemos los resultados
        $resultado = $this->db->executeQuery($sql, [$codigo]);

        // Si no existe el usuario → falso
        return $resultado ? $resultado[0] : [];
    }   
}
