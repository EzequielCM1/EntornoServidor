<?php
/**
* Ejercicio realizado por P.Lluyot. 2DAW
*/
$mensaje = "";
$color = "";

//cuando cargamos la página preguntamos si existe la cookie
if (isset($_COOKIE['color_usuario']))
    $color = $_COOKIE['color_usuario'];
//si hemos pulsado el botón enviar
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['enviar'])) {
    $color =  $_POST['color'];
    //almacenamos la cookie
    setcookie("color_usuario", $color, time() + 3600); // 1 hora

    //recargamos la página
    header("Location: e2_color.php");
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
        <?php
        //llegados a este punto, podemos no tener el color o bien tenerlo ya sea de la cookie o bien del formulario.
        if (!empty($color)) echo "body{background-color:$color;}";
        ?>
    </style>
</head>

<body>
    <header>
        <h2>Color fondo - Cookies</h2>
    </header>
    <main>
        <!-- código php -->
        <form action="e2_color.php" method="post">
            <p>
                <label for="color">Selecciona un color:
                    <input type="color" name="color" id="color">
                </label>
            </p>
            <input type="submit" name="enviar" value="enviar">
        </form>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>