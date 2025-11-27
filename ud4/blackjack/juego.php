<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
} else {
    $nombre = $_SESSION['nombre'] ?? '';
}
$dinero = $_SESSION['dinero'] ?? 0;


if ($dinero <= 0) {
    header("Location: perdiste.php");
    exit();
}



function crearMazo()
{
    $valores = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10];
    $mazo = [];

    for ($i = 0; $i < 4; $i++) {
        foreach ($valores as $v) $mazo[] = $v;
    }

    shuffle($mazo);
    return $mazo;
}

function robar()
{
    return array_pop($_SESSION['mazo']);
}

function puntos($mano)
{
    $total = array_sum($mano);
    if (in_array(1, $mano) && $total + 10 <= 21) {
        $total += 10;
    }
    return $total;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['apostar'])) {
    $dineroApostado = intval($_POST['apuesta'] ?? 0);

    if ($dineroApostado == 0) {
        $mensaje = "No puedes apostar 0 ";
    } elseif ($dineroApostado > $dinero) {
        $mensaje = "No tienes esa cantidad de dinero";
    } else {
        $_SESSION['apuesta'] = $dineroApostado;
        // Crear mazo y repartir
        $_SESSION['mazo'] = crearMazo();
        $_SESSION['jugador'] = [robar(), robar()];
        $_SESSION['crupier'] = [robar()];
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
            color: red;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <header>
        <h1>blackjack</h1>
    </header>

    <main>
        <h3>Hola <?= $nombre ?> </h3>
        <p>Tienes: <?= $dinero ?>€</p>
        <form action="" method="post">
            <input type="number" name="apuesta"><br>
            <?php if (!empty($mensaje)):  ?>
                <span><?= $mensaje ?></span><br>
            <?php endif; ?><br>
            <button type="submit" name="apostar">Apostar</button>
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>