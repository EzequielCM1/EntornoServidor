<?php

require_once APP_ROOT .'/includes/Database.php';

class ProductosModel{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function createProducto($nombre, $descripcion, $precio){
        //insertamos usando la fecha actual (now() y null en categoria por ahora
        $sql = "INSERT INTO productos (nombre, descripcion, precio, fecha_creacion) VALUES (?, ?, ?, NOW())";
        return $this->db->executeUpdate($sql, [$nombre, $descripcion, $precio]);
    }

    public function obtenerTodos(){
        $sql = "SELECT * FROM productos";
        return $this->db->executeQuery($sql);
    }
}