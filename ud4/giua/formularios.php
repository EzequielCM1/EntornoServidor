<?php
// ----------------------------------------------------------
//   PROCESAR FORMULARIO
// ----------------------------------------------------------
$errores = [];
$nombre = "";
$edad = 0;
$precio = 0;
$email = "";
$fecha = "";
$hora = "";

// Cuando el formulario se envíe:
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ==========================
    //  TEXTO (nombre)
    // ==========================
    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)) {
        $errores[] = "El nombre solo puede contener letras.";
    }

    // ==========================
    //  ENTERO (edad)
    // ==========================
    $edad = intval($_POST["edad"] ?? 0);

    if ($edad <= 0) {
        $errores[] = "La edad debe ser un número entero mayor que 0.";
    }

    // ==========================
    //  DECIMAL (precio)
    // ==========================
    $precio = floatval($_POST["precio"] ?? 0);

    if ($precio <= 0) {
        $errores[] = "El precio debe ser un número decimal mayor que 0.";
    }

    // ==========================
    //  EMAIL
    // ==========================
    $email = trim($_POST["email"] ?? "");

    if ($email === "") {
        $errores[] = "El email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // ==========================
    //  FECHA (YYYY-MM-DD)
    // ==========================
    $fecha = trim($_POST["fecha"] ?? "");

    if ($fecha === "") {
        $errores[] = "La fecha es obligatoria.";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
        $errores[] = "Formato de fecha no válido.";
    }

    // ==========================
    //  HORA (HH:MM)
    // ==========================
    $hora = trim($_POST["hora"] ?? "");

    if ($hora === "") {
        $errores[] = "La hora es obligatoria.";
    } elseif (!preg_match("/^\d{2}:\d{2}$/", $hora)) {
        $errores[] = "Formato de hora no válido.";
    }

    // ----------------------------------------------------------
    //   SI TODO ES CORRECTO
    // ----------------------------------------------------------
    if (empty($errores)) {
        $mensaje_ok = "Datos recibidos correctamente:";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía de Formulario</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .card { background: white; padding: 20px; width: 400px; margin: auto; border-radius: 10px; }
        input, button { width: 100%; padding: 8px; margin: 6px 0; }
        .error { color: red; padding: 4px 0; }
        .ok { color: green; font-weight: bold; }
        .datos { background: #e8ffe8; padding: 10px; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Guía de Formulario PHP</h2>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $e): ?>
            <div class="error"><?= $e ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($mensaje_ok)): ?>
        <div class="ok"><?= $mensaje_ok ?></div>
        <div class="datos">
            <p><b>Nombre:</b> <?= htmlspecialchars($nombre) ?></p>
            <p><b>Edad:</b> <?= htmlspecialchars($edad) ?></p>
            <p><b>Precio:</b> <?= htmlspecialchars($precio) ?></p>
            <p><b>Email:</b> <?= htmlspecialchars($email) ?></p>
            <p><b>Fecha:</b> <?= htmlspecialchars($fecha) ?></p>
            <p><b>Hora:</b> <?= htmlspecialchars($hora) ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <label>Nombre (texto):</label>
        <input type="text" name="nombre" value="<?= $nombre ?>">

        <label>Edad (entero):</label>
        <input type="number" name="edad" value="<?= $edad ?>">

        <label>Precio (decimal):</label>
        <input type="text" name="precio" value="<?= $precio ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= $email ?>">

        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?= $fecha ?>">

        <label>Hora:</label>
        <input type="time" name="hora" value="<?= $hora ?>">

        <button type="submit">Enviar</button>
    </form>
</div>

</body>
</html>
