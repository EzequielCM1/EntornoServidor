<?php
$mensaje = "";
$numero1 = "";
$numero2 = "";
$operacion = "";
$resultado = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recuperamos 
    $numero1 = htmlspecialchars(trim($_POST['numero1'] ?? ''));
    $numero2 = htmlspecialchars(trim($_POST['numero2'] ?? ''));
    $operacion = htmlspecialchars(trim($_POST['operacion'] ?? ''));


    $numero1 = floatval($_POST['numero1']);
    $numero2 = floatval($_POST['numero2']);

    switch ($operacion) {
        case "+":
            $resultado = $numero1 + $numero2;
            break;
        case "-":
            $resultado = $numero1 - $numero2;
            break;
        case "/":
            $resultado = $numero1 / $numero2;
            break;
        case "*":
            $resultado = $numero1 * $numero2;
            break;
    }
    $mensaje = "<h4>Calculo</h4>";
    $mensaje .= "<p>El resultado es de : $resultado</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <title>Document</title>
</head>

<body>
    <h1>Calculadora</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POSTS">
        <label for="numero1">Numero 1</label>
        <input type="number" name="numero1" id="numero1" placeholder="numero1">
        <label for="numero2">Numero 1</label>
        <input type="number" name="numero2" id="numero2" placeholder="numero2">
        <h3>Que deseas realizar?</h3>
        <button type="submit" name="operacion" value="+">+</button>
        <button type="submit" name="operacion" value="-">-</button>
        <button type="submit" name="operacion" value="/">/</button>
        <button type="submit" name="operacion" value="*">*</button>
    </form>
    <pre>
    <?php
    echo $mensaje;
    ?>
    </pre>
</body>

</html>