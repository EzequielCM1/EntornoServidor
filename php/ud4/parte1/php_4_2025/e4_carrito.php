<?php
/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
$errores=[];
$carrito =[];
// Inicializar el carrito con el array almacenado en la cookie (si existe).
if (isset($_COOKIE['carrito'])){
    $carrito = @unserialize($_COOKIE['carrito']);
    if (!is_array($carrito)) $carrito = []; // Verificar si la deserialización fue exitosa
} 

//función que genera una lista de productos en el carrito.
function mostrar_carrito($carrito){
    if (empty($carrito)) return "El carrito está vacío.";
    else {
        $lista =  "<ul>";
        foreach ($carrito as $item) {
            $lista.= "<li>" . htmlspecialchars($item) . "</li>";
        }
        $lista .= "</ul>";
        return $lista;
    }
}

// Añadir producto al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['anadir'])) {
    $producto = htmlspecialchars(stripslashes(trim($_POST['producto']??'')));
    if (empty($producto)){
        $errores['producto']="El producto no puede estar vacío";
    }else{
        $carrito[] = $producto; //sanitizamos
        setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/"); // 30 días
    }
    // Redirigir para evitar reenvío del formulario.
    header("Location: " . $_SERVER['PHP_SELF']); //get --> depurar para ver el funcionamiento
    exit();  
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])){
    setcookie('carrito', '', time() - 3600, "/"); 
    // Redirigir para evitar reenvío del formulario.
    header("Location: " . $_SERVER['PHP_SELF']); //get --> depurar para ver el funcionamiento
    exit();
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <style>
        small {
            font-size: small;
            margin-bottom: 5px;
            display: block;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h2>Carrito con cookies</h2>
    </header>
    <main>
        <h3>Añadir producto al carrito</h3>

        <form method="post" action="e4_carrito.php">
            <p>
                <input type="text" name="producto" placeholder="Nombre del producto">
                <?php if (!empty($errores['producto'])) echo "<small>{$errores['producto']}</small>"; ?>
                <input type="submit" name="anadir" value="Añadir">
                <input type="submit" name="eliminar" value="Vaciar Carrito">
            </p>
        </form>
        <div class='notice'>
            <?php
                echo mostrar_carrito($carrito);
            ?>
        </div>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>