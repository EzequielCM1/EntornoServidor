<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['juego'])) {
    iniciarJuego();
}

$mensaje = "";

if (isset($_POST['reinicar'])) {
        header("Location: fin.php");
        exit();
    }
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $letra = htmlspecialchars(trim(strtolower($_POST['letra'] ?? '')));
    if (strlen($letra) == 1 && preg_match('/^[a-zñ]$/', $letra)) {
        $mensaje = procesarLetra($letra);

        if (victoria()) {
            $mensaje = "Has ganado !! La palabra era :<strong>". $_SESSION['juego']['palabra'];
        }
        if (derrota()) {
            $mensaje = "Has perdido :( , la palabra era :<strong>". $_SESSION['juego']['palabra'] ;
        }
    } else {
        $mensaje = "Debes introducir una letra de la A-Z";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ahorcado</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <link rel="stylesheet" href="./styles/ahorcado.css">
</head>

<body>
    <header>
        <h1>Juego del ahorcado</h1>
    </header>

    <main>
        
        <div class="informacion">
        <img src="./img/turno<?= $_SESSION['juego']['errores'] ?>.png" alt="">

        <div class="notice">
        <table>
            <tbody>
                <tr>
                    <td><p>Turno </p></td>
                    <td><p><?= $_SESSION['juego']['turno'] ?></p></td>
                </tr>
                <tr>
                    <td><p>Errores </p></td>
                    <td><p><?= $_SESSION['juego']['errores'] ?>/6</p></td>
                </tr>
            </tbody>
        </table>
        <div>
        <h3>Letras usadas</h3>
        <p><?= implode(", ", $_SESSION['juego']['usadas']) ?></p>
        </div>
        </div>
        </div>
        <h1><?= $_SESSION['juego']['palabraMostrada']  ?></h1>
        <?php if (!empty($mensaje)) : ?>
            <div class="notice"><?= $mensaje ?></div>
        <?php endif; ?>

        <?php if (!victoria() && !derrota()):  ?>
            <form action="" method="post">
                <label for="letra">Nombre:</label>
                <input type="text" id="letra" name="letra" />

                <button type="submit">Enviar</button>
            </form>
            <?php endif;  ?>
            <form action="" method="post"><input type="submit" name="reinicar" value="reinicar"></form>
        
    </main>

    <footer>
        <p>Ezequiel Campos </p>
    </footer>
</body>

</html>