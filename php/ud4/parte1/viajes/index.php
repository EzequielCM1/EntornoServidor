<?php
session_start();


if (isset($_SESSION['viaje'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
$errores = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $destino = htmlspecialchars(trim($_POST['destino']?? ""));
    $dias = htmlspecialchars($_POST['dias']??0);

    if(empty($destino)){
        $errores['destino'] = "debes introducir el destino";
    }
    if(empty($dias)){
        $errores['dias'] = "debes introducir el numero de dias ";
    }

    if(empty($errores)){
        $_SESSION['viaje'] = [
            "destino" => $destino,
            "dias" => $dias,
            "itinerario" => []
        ];
        
        for($i = 1; $i <= $dias ; $i ++){
            $_SESSION['viaje']['itinerario']['dia'.$i]=[];
        }
        // echo "<pre>";
       // print_r($_SESSION['viaje']);
       // echo "</pre>";
        header("Location: planificar.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>
        .error {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Itirenario de viaje</h1>
    </header>

    <main>
        <form action="" method="POST">
            <label>Destino :</label>
            <input type="text" name="destino"><br>
            <?php if (!empty($errores['destino'])): ?>
                    <span class="error"><?= $errores['destino'] ?></span>
                <?php endif; ?>
            <label>Dias :</label>
            <input type="number" name="dias"><br>
            <?php if (!empty($errores['dias'])): ?>
                    <span class="error"><?= $errores['dias'] ?></span>
                <?php endif; ?><br>
            <button type="submit">Viajar !!</button>
            
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>