<?php
$errores = [];
$ruta = "repaso1.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $apellidos = htmlspecialchars(trim($_POST['apellidos'] ?? ''));
    $correo = htmlspecialchars(trim($_POST['email'] ?? ''));
    $peso = intval($_POST['peso'] ?? 0);
    $altura = floatval($_POST['altura'] ?? 0);

    // Validaciones
    if (empty($nombre)) {
        $errores['nombre'] = "Debe contener un nombre";
    }
    if (empty($apellidos)) {
        $errores['apellidos'] = "Debe contener un apellido";
    }
    if ($peso < 0 || empty($peso)) {
        $errores['peso'] = "el peso no debe ser menor de 0";
    }
    if ($altura < 1 || empty($altura)) {
        $errores['altura'] = "la altura debe ser mayor de 1 metro ";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es valido ";
    }

    if(empty($errores)){
        $usuarioNuevo = [$nombre, $apellidos, $correo, $peso, $altura];
        $copiar = implode("," ,$usuarioNuevo);
        $fichero = fopen($ruta, "a");
        file_put_contents($ruta, $copiar);
        fclose($fichero);
        header("Location: repaso1Listado.php?nombre=$nombre");
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
        <h1>Registro</h1>
    </header>

    <main>
        <form action="" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" />
            <?php if (!empty($errores['nombre'])) : ?>
                <br /><span class="error"><?= $errores['nombre'] ?></span>
            <?php endif; ?>
            <label for="apellidos">Apellidos :</label>
            <input type="text" id="apellidos" name="apellidos" />
            <?php if (!empty($errores['apellidos'])) : ?>
                <br /><span class="error"><?= $errores['apellidos'] ?></span>
            <?php endif; ?>
            <label for="email">Correo:</label>
            <input type="text" id="email" name="email" />
            <?php if (!empty($errores['correo'])) : ?>
                <br /><span class="error"><?= $errores['correo'] ?></span>
            <?php endif; ?>
            <label for="mensaje">Peso :</label>
            <input type="number" id="peso" name="peso">
            <?php if (!empty($errores['peso'])) : ?>
                <br /><span class="error"><?= $errores['peso'] ?></span>
            <?php endif; ?>
            <label for="mensaje">Altura :</label>
            <input type="number" id="altura" name="altura" step="0.01">
            <?php if (!empty($errores['altura'])) : ?>
                <br /><span class="error"><?= $errores['altura'] ?></span>
            <?php endif; ?>
            <br>
            <br>
            <button type="submit">Guardar</button>
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>