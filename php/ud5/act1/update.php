<?php
session_start();
require_once './function/ejercicio1.php';
$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$database = "tienda";
$id = $_GET['id'] ?? '';

if ($id === '') {
    header("location: select.php");
    exit();
} else {
    $conexion = conectarBD($host, $user, $password, $database);
    $consulta = $conexion->query("SELECT * FROM productos WHERE id_producto=$id");
    if ($consulta->num_rows > 0) {
        while ($fila = $consulta->fetch_assoc()) {
            $nombre = $fila['nombre']??'';
            $descripcion = $fila['descripcion']??'';
            $precio = $fila["precio"]??0;
        }
    }
    cerrarBD($conexion);
}

$mensaje = "";
$errores = [];



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['actualizar'])) {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $descripcion = htmlspecialchars(trim($_POST['descripcion'] ?? ''));
    $precio = htmlspecialchars(trim($_POST['precio'] ?? 0));

    if (empty($nombre)) {
        $errores['nombre'] = "El nombre no puede estar vacio";
    }
    if (empty($descripcion)) {
        $errores['descripcion'] = "La descripcion no puede estar vacio";
    }
    if ($precio == 0) {
        $errores['precio'] = "El precio no puede estar vacio";
    }

    if (empty($errores)) {


        $conexion = conectarBD($host, $user, $password, $database);

        $consulta = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio WHERE id_producto=$id";


        if ($conexion->query($consulta) == TRUE) {
            if ($conexion->affected_rows > 0) {
                $mensaje = "Producto actualizado correctamente";
            } else {
                $mensaje = "No se ha encontrado la id o no se ha modificado nada ";
            }
        } else {
            $mensaje = "Error en actualiazar el producto " . $conexion->error;
        }

        // mysqli_report()
        $_SESSION['mensaje'] = $mensaje;

        cerrarBD($conexion);
        header("Location: select.php");
        exit();
    }
}else{
    if(isset($_POST['cancelar'])){
        header("Location: select.php");
        exit();
    }
}


?>

<?php include __DIR__ . '/views/layout/header.php'; ?>
<main>
    <h2>Actualizar el producto</h2>
    <form action="" method="post">
        <label for="id">ID : </label>
        <input type="text" name="id" id="id" value="<?= $id ?>" readonly>

        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $nombre ?>" /><br>
        <?php if (!empty($errores['nombre'])): ?>
            <span class="error"><?= $errores['nombre'] ?></span>
        <?php endif; ?>

        <label for="descripcion">Descripcion :</label>
        <textarea name="descripcion" id="descripcion"><?= $descripcion ?></textarea><br>
        <?php if (!empty($errores['descripcion'])): ?>
            <span class="error"><?= $errores['descripcion'] ?></span>
        <?php endif; ?>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?= $precio ?>" /><br>
        <?php if (!empty($errores['precio'])): ?>
            <span class="error"><?= $errores['precio'] ?></span><br>
        <?php endif; ?>

        <br>
        <button type="submit" name="actualizar">Actualizar</button>
        <button type="submit" name="cancelar">Cancelar</button>
    </form>
</main>
<?php include __DIR__ . '/views/layout/footer.php'; ?>