<?php
session_start();
$id = $_GET['id']??'';
$mensaje = "";
if($id===''){
    header("location: select.php");
    exit();
}
$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$database = "tienda";
require_once './function/ejercicio1.php';

$conexion = conectarBD($host, $user, $password, $database);

$consulta = "DELETE FROM productos WHERE id_producto=$id";
if($conexion->query($consulta)=== true){
    if($conexion->affected_rows> 0){
        $mensaje = "Producto eliminado correctamente";
    }else{
        $mensaje = "No se encontro ningun producto con esa id";
    }
}else{
    $mensaje = "Error al intentar eliminar la base de datos ".$conexion->error;
}
 // mysqli_report()
$_SESSION['mensaje'] = $mensaje;
cerrarBD($conexion);
header("Location: select.php");
        exit();

?>