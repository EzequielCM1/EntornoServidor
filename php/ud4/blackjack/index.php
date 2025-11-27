<?php
session_start();

if (isset($_SESSION['nombre'])) {
    header("Location: juego.php");
    exit();
} else {
    $nombre = '';
}
$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));

    if (empty($nombre)) {
        $error = "Introdce tu nombre";
    } else {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['dinero'] = 300;
        header("Location: juego.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>blackjack</title>
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
        <h1>blackjack</h1>
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