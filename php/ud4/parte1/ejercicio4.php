<?php
$carrito = [];

if (isset($_COOKIE['carrito'])) $carrito = json_decode($_COOKIE['carrito']); // otra forma es con unserialize()

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['eliminar'])) {
    setcookie('carrito', "", time() - 3600, "/");
    header("Location: ejercicio4.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['aniadir'])) {

    $listaNueva = $_POST['compra'] ?? '';
    if (!empty($listaNueva)) {
        array_push($carrito, $listaNueva);
    }

    setcookie('carrito', json_encode($carrito), time() + 3600, "/"); // otra forma es serialize()
    header("Location: ejercicio4.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cookies</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Carrito</h1>
    </header>

    <main>
        <form action="" method="POST">
            <label for="carrito">Añadir al carrito</label>
            <input type="text" name="compra">
            <br>
            <input type="submit" name="aniadir" value="aniadir"></input>
            <input type="submit" name="eliminar" value="eliminar"></input>
        </form>
        <div class="notice">
            <?php
            if (empty($carrito)) {
                echo "<p>El carrito eta vacio</p>";
            }
            echo "<ul>";
            foreach ($carrito as $a) {
                echo "<li>$a</li>";
            }
            echo "</ul>";
            ?>
        </div>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>