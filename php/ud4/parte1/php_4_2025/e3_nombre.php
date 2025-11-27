<?php

/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
$nombre_usuario = '';

// Verificamos si ya hay un nombre guardado en la cookie
if (isset($_COOKIE['nombre_usuario'])) {
    // Si existe, lo almacenamos en una variable
    $nombre_usuario = sanitizarEntrada($_COOKIE['nombre_usuario']??'');
}

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizamos la entrada del usuario
    $nombre_usuario = sanitizarEntrada($_POST['nombre'] ?? '');
    if ($nombre_usuario != '') {
        // Guardamos el nombre en una cookie que expira en 30 días
        setcookie('nombre_usuario', $nombre_usuario, time() + (5 * 60), "/"); // 15 minutos

        // Redirigimos para evitar el reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Función para sanitizar entradas
function sanitizarEntrada($data)
{
    // Eliminar espacios en blanco al inicio y al final
    $data = trim($data);
    // Eliminar barras invertidas
    $data = stripslashes($data);
    // Convertir caracteres especiales a entidades HTML
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php
//código php
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Uso de cookies</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Almacenamiento de cookie de usuario</h2>
    </header>
    <main>
        <!-- código php -->
        <?php if ($nombre_usuario != ''):
            echo "<p class='notice'>¡Bienvenido, $nombre_usuario !</p>";
        else : ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="nombre">Ingresa tu nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <input type="submit" value="Enviar">
            </form>
        <?php endif; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>