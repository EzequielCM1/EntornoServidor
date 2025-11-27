<?php
session_start();
$error = "";
$nombre = $_SESSION['usuario']??'';
if(!empty($nombre)){
    header("Location: p1.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));

    if (empty($nombre)) {
        $error = "Introdce tu nombre";
    } else {
        $_SESSION['usuario'] = $nombre;
        header("Location: p1.php");
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
        span {
            font-size: 15px;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Encuesta interactiva con sesiones   </h1>
    </header>

    <main>
        <form action="" method="post">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?= $nombre ?>" /><br>
            <?php if (!empty($error)):  ?>
                <span><?= $error ?></span>
            <?php endif; ?><br>
            <button type="submit">Enviar</button>
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>