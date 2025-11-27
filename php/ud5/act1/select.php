<?php
require_once './function/ejercicio1.php';

session_start();
$mensaje = $_SESSION['mensaje'] ?? "";

$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$database = "tienda";

$tabla = "";

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {

    if (isset($_GET['eliminar'])) {
        header("Location: delete.php?id=" . $_GET['id']);
        exit();
    }
    if (isset($_GET['actualizar'])) {
        header("Location: update.php?id=" . $_GET['id']);
        exit();
    }
}else{
    if(isset($_POST['insertar'])){
        header("Location: insertar1.php");
        exit();
    }
}



?>
<?php include __DIR__ . '/views/layout/header.php'; ?>

<main>
    <h3>Lista de productos:</h3>
    <?php
    if (!empty($mensaje)) { ?>
        <p class="notice"><?= $mensaje ?></p>
    <?php } ?>
    <form action="" method="post">
        <button type="submit" name="insertar">Insertar</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Botones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conexion = conectarBD($host, $user, $password, $database);
            $resultado = $conexion->query("SELECT * FROM productos");
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {

                            echo  '<tr>
                        <td>' . $fila['id_producto'] . '</td>
                        <td>' . $fila['nombre'] . '</td>
                        <td>' . $fila['descripcion'] . '</td>
                        <td>' . $fila['precio'] . '€</td>
                        <td>
                             <form action="" method="GET">
                             <input type="hidden" name="id" value="' . $fila['id_producto'] . '">
                             <button type="submit" name="eliminar">Eliminar</button>
                             <button type="submit" name="actualizar">Actualizar</button>
                             </form>
                        </td>
                    </tr>';
                }
            } else {
                echo "No se ha encontrado produvtos";
            }
            cerrarBD($conexion);
            ?>
            </tbody>

    </table>
</main>

<?php
unset($_SESSION['mensaje']);
include __DIR__ . '/views/layout/footer.php'; ?>