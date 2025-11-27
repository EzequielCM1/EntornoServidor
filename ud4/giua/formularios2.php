<?php
// ----------------------------------------------------------
//   PROCESAR FORMULARIO
// ----------------------------------------------------------
$errores = [];
$nombre = $edad = $precio = $email = $fecha = $hora = $url = $ip = $numero_dec = "";

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
    //  ENTERO (edad) con rango
    // ==========================
    $edad = $_POST["edad"] ?? "";

    $edadValidada = filter_var($edad, FILTER_VALIDATE_INT, [
        "options" => [
            "min_range" => 1,
            "max_range" => 120
        ]
    ]);

    if ($edadValidada === false) {
        $errores[] = "La edad debe ser un número entero entre 1 y 120.";
    } else {
        $edad = $edadValidada;
    }

    // ==========================
    //  DECIMAL (precio) con rango
    // ==========================
    $precio = trim($_POST["precio"] ?? "");

    $precioValidado = filter_var($precio, FILTER_VALIDATE_FLOAT);

    if ($precioValidado === false) {
        $errores[] = "El precio debe ser un número decimal.";
    } elseif ($precioValidado < 0.50 || $precioValidado > 9999.99) {
        $errores[] = "El precio debe estar entre 0.50 y 9999.99.";
    } else {
        $precio = $precioValidado;
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
    //  FECHA (validación completa)
    // ==========================
    $fecha = trim($_POST["fecha"] ?? "");

    if ($fecha === "") {
        $errores[] = "La fecha es obligatoria.";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
        $errores[] = "Formato de fecha no válido.";
    } else {
        // Validar si la fecha existe realmente
        list($y, $m, $d) = explode("-", $fecha);
        if (!checkdate($m, $d, $y)) {
            $errores[] = "La fecha no existe.";
        }

        // Validar rango de fecha
        $fechaMin = "2024-01-01";
        $fechaMax = "2025-12-31";

        if ($fecha < $fechaMin || $fecha > $fechaMax) {
            $errores[] = "La fecha debe estar entre $fechaMin y $fechaMax.";
        }
    }

    // ==========================
    //  HORA (HH:MM)
    // ==========================
    $hora = trim($_POST["hora"] ?? "");

    if ($hora === "") {
        $errores[] = "La hora es obligatoria.";
    } elseif (!preg_match("/^\d{2}:\d{2}$/", $hora)) {
        $errores[] = "Formato de hora no válido.";
    } else {
        // Rango horario permitido
        $horaMin = "09:00";
        $horaMax = "18:00";

        if ($hora < $horaMin || $hora > $horaMax) {
            $errores[] = "La hora debe estar entre $horaMin y $horaMax.";
        }
    }

    // ==========================
    //  URL (nueva validación)
    // ==========================
    $url = trim($_POST["url"] ?? "");

    if ($url !== "" && !filter_var($url, FILTER_VALIDATE_URL)) {
        $errores[] = "La URL no es válida.";
    }

    // ==========================
    //  IP (nueva validación)
    // ==========================
    $ip = trim($_POST["ip"] ?? "");

    if ($ip !== "" && !filter_var($ip, FILTER_VALIDATE_IP)) {
        $errores[] = "La IP no es válida.";
    }

    // ==========================
    //  NÚMERO DECIMAL SANITIZADO
    // ==========================
    $numero_dec = filter_var($_POST["numero_dec"] ?? "", 
        FILTER_SANITIZE_NUMBER_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION
    );

    if ($numero_dec !== "" && !filter_var($numero_dec, FILTER_VALIDATE_FLOAT)) {
        $errores[] = "El número decimal introducido no es válido.";
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
        .card { background: white; padding: 20px; width: 450px; margin: auto; border-radius: 10px; }
        input, button { width: 100%; padding: 8px; margin: 6px 0; }
        .error { color: red; padding: 4px 0; }
        .ok { color: green; font-weight: bold; }
        .datos { background: #e8ffe8; padding: 10px; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Guía Completa de Validación PHP</h2>

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
            <p><b>URL:</b> <?= htmlspecialchars($url) ?></p>
            <p><b>IP:</b> <?= htmlspecialchars($ip) ?></p>
            <p><b>Número Decimal Sanitizado:</b> <?= htmlspecialchars($numero_dec) ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <label>Nombre (texto):</label>
        <input type="text" name="nombre" value="<?= $nombre ?>">

        <label>Edad (entero 1-120):</label>
        <input type="number" name="edad" value="<?= $edad ?>">

        <label>Precio (decimal 0.50 - 9999.99):</label>
        <input type="text" name="precio" value="<?= $precio ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= $email ?>">

        <label>Fecha (2024-2025):</label>
        <input type="date" name="fecha" value="<?= $fecha ?>">

        <label>Hora (09:00 - 18:00):</label>
        <input type="time" name="hora" value="<?= $hora ?>">

        <label>URL (opcional):</label>
        <input type="text" name="url" value="<?= $url ?>">

        <label>IP (opcional):</label>
        <input type="text" name="ip" value="<?= $ip ?>">

        <label>Número decimal (sanitizado):</label>
        <input type="text" name="numero_dec" value="<?= $numero_dec ?>">

        <button type="submit">Enviar</button>
    </form>
</div>

</body>
</html>
