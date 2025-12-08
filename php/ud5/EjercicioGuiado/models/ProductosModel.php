<?php

require_once APP_ROOT . '/includes/Database.php';

class ProductosModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function createProducto($nombre, $descripcion, $precio)
    {
        //insertamos usando la fecha actual (now() y null en categoria por ahora
        $sql = "INSERT INTO productos (nombre, descripcion, precio, fecha_creacion) VALUES (?, ?, ?, NOW())";
        return $this->db->executeUpdate($sql, [$nombre, $descripcion, $precio]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM productos";
        return $this->db->executeQuery($sql);
    }

    public function borrarProductos($id)
    {
        $sql = "DELETE FROM productos where id_producto = ?";
        return $this->db->executeUpdate($sql, [$id]);
    }
    public function actualizarProductos($nombre, $descripcion, $precio, $id)
    {
        $sql = "UPDATE productos 
            SET nombre = ?, descripcion = ?, precio = ?
            WHERE id_producto = ?";
        return $this->db->executeUpdate($sql, [$nombre, $descripcion, $precio, $id]);
    }
    public function buscarId($id)
    {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        return $this->db->executeQuery($sql, [$id]);
    }

    public function buscarProductoNombre($nombre)
    {
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? ORDER BY id_producto ASC";
        return $this->db->executeQuery($sql, [$nombre . '%']); // esto hara que busque si comienza igual
    }
    /*    public function buscarProductoNombre($nombre){ Esto es lo mismo pero ignorando las mayusculas
    $sql = "SELECT * FROM productos 
            WHERE LOWER(nombre) LIKE LOWER(?) 
            ORDER BY id_producto ASC";

    return $this->db->executeQuery($sql, [$nombre . '%']);
    } */
}
