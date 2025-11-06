<?php
session_start();
$usuario= "";
if(!isset($_SESSION['usuario'])){
    // si no existe 
    header("Location: sesionEjercicio2LoginB.php");
    exit();
}else{
    $usuario = $_SESSION['usuario'];
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
        <h1>Principal</h1>
    </header>

    <main>
        <h3>Bienvenido <?= htmlspecialchars($usuario)?> !!!</h3>
        <p><a href="./logaut.php">Logaut</a></p>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>