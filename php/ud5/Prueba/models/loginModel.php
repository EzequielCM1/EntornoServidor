<?php

require_once APP_ROOT . '/includes/Database.php';

class LoginModel
{

    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function buscarUsuario($nombre, $password)
    {
        $sql = 'SELECT password FROM usuarios WHERE usuario = ? ';
        $data = $this->db->executeQuery($sql, [$nombre]); // le metemos lso paramatros segun la sentencia en el array , por cada ? es un parametro en el array
        if (empty($data)) {
            return false;
        }
        //comprobar si devuelve datos $data[0]['password'] --> este es el password encriptado (hasheado)
        $passwordHash = $data[0]['password'];
        //llammar password_verify($password, $passwdEncriptado) --> true/false
        if (password_verify($password, $passwordHash)) {
            return true;  // login correcto
        } else {
            return false; // contraseña incorrecta
        }
        //return
    }
    public function comprobarRol($nombre){
        $sql = 'SELECT rol FROM usuarios WHERE usuario = ? ';
        $data = $this->db->executeQuery($sql, [$nombre]);

        return $rolUsuario = $data[0]['rol'];
    }
    public function registrarUsuario($nombre, $password){
        $sql = 'INSERT INTO usuarios (usuario, password) values (?, ?)';
        return $this->db->executeUpdate($sql, [$nombre, $password]);
    }
}
