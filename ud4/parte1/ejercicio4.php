<?php
$carrito = [];

    if(isset($_COOKIE['carrito'])){
        $carrito = json_decode($_COOKIE['carrito']);
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $listaNueva = $_POST['compra']??'';
        array_push($carrito, $listaNueva);
        
    setcookie('carrito', json_encode($carrito), time()+3600);
    header("Location: ejercicio4.php");
    exit();
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Titulo</h1>
    </header>

    <main>
        <form action="" method="POST">
            <label for="carrito">Añadir al carrito</label>
            <input type="text" name="compra">
            <br>
            <button type="submit" value="agregar">Añadir</button>
        </form>
        <div class="notice">
        <?php
        echo "<ul>";
        foreach($carrito as $a){
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