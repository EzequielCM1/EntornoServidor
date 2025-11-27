<?php
// -------------------------
// INICIALIZAR EL ARRAY
// -------------------------
session_start();

if (!isset($_SESSION["lista"])) {
    $_SESSION["lista"] = [];
}

// -------------------------
// AÑADIR ELEMENTO
// -------------------------
if (isset($_POST["add"])) {
    $nombre = trim($_POST["nombre"]);
    if ($nombre !== "") {
        $_SESSION["lista"][] = $nombre;
    }
}

// -------------------------
// ELIMINAR ELEMENTO POR NOMBRE
// -------------------------
if (isset($_POST["delete"])) {
    $nombre = trim($_POST["nombre"]);
    if ($nombre !== "") {
        $index = array_search($nombre, $_SESSION["lista"]);
        if ($index !== false) {
            unset($_SESSION["lista"][$index]);
            $_SESSION["lista"] = array_values($_SESSION["lista"]);
        }
    }
}

// -------------------------
// ELIMINAR PRIMERO
// -------------------------
if (isset($_POST["delete_first"])) {
    if (!empty($_SESSION["lista"])) {
        array_shift($_SESSION["lista"]);
    }
}

// -------------------------
// ELIMINAR ÚLTIMO
// -------------------------
if (isset($_POST["delete_last"])) {
    if (!empty($_SESSION["lista"])) {
        array_pop($_SESSION["lista"]);
    }
}

// -------------------------
// MOSTRAR LISTA (solo activa flag)
// -------------------------
$mostrar = isset($_POST["show"]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo Arrays</title>

    <!-- CSS ultra simple (PicoCSS) -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

</head>
<body class="container">

    <h1>Gestión de Array en PHP</h1>

    <!-- FORMULARIO -->
    <form method="POST">

        <label>Nombre a añadir o eliminar:</label>
        <input type="text" name="nombre" placeholder="Introduce un nombre">

        <button name="add">Añadir</button>
        <button name="delete">Eliminar por nombre</button>
        <button name="delete_first">Eliminar primero</button>
        <button name="delete_last">Eliminar último</button>
        <button name="show">Mostrar lista</button>
    </form>

    <hr>

    <?php if ($mostrar): ?>
        <h2>Contenido del Array</h2>

        <?php if (empty($_SESSION["lista"])): ?>
            <p><b>La lista está vacía.</b></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Elemento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION["lista"] as $i => $valor): ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($valor) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php endif; ?>

</body>
</html>
