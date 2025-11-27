<?php
session_start();
require_once './function/ejercicio1.php';
define('APP_ROOT', dirname(__DIR__));

$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$database = "tienda";

$nombre = "";
$descripcion = "";
$precio = 0;
$errores = [];
$mensaje = $_SESSION['mensaje']??'';
unset($_SESSION['mensaje']);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['insertar'])) {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $descripcion = htmlspecialchars(trim($_POST['descripcion'] ?? ''));
    $precio = htmlspecialchars(trim($_POST['precio'] ?? 0));

    if (empty($nombre)) {
        $errores['nombre'] = "El nombre no puede estar vacio";
    }
    if (empty($descripcion)) {
        $errores['descripcion'] = "La descripcion no puede estar vacio";
    }
    if (empty($precio)) {
        $errores['precio'] = "El precio no puede estar vacio";
    }

    if (empty($errores)) {

        $conexion = conectarBD($host, $user, $password, $database);

        $consulta = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('{$nombre}', '{$descripcion}', $precio)";

        if (mysqli_query($conexion, $consulta)) {
            $mensaje =  "Producto insertado";
        } else {
            $mensaje =  "Error en insertar el producto : " . mysqli_error($conexion);
        }
        $_SESSION['mensaje'] = $mensaje;
        header("Location: select.php");
        exit();
        cerrarBD($conexion);
    }
}else{
    if(isset($_POST['cancelar'])){
        header("Location: select.php");
        exit();
    }
}

include __DIR__ . '/./views/layout/header.php';

?>

    <main>
        <form action="" method="post">
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
            <input type="number" id="precio" name="precio" value="<?= $precio ?>"/><br>
            <?php if (!empty($errores['precio'])): ?>
                <span class="error"><?= $errores['precio'] ?></span>
            <?php endif; ?>

            <br>
            <button type="submit" name="insertar">Insertar</button>
        <button type="submit" name="cancelar">Cancelar</button>
        </form>
    </main>
<?php include __DIR__ . '/./views/layout/footer.php'; ?>