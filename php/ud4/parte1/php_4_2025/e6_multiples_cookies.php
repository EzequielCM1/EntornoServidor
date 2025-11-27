<?php
/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */

// Inicializamos variables para las cookies
$nombre = "";
$color = "";

if (isset($_POST['guardar'])) {
    // Guardar nombre y color en cookies
    $nombre = $_POST['nombre'];
    $color = $_POST['color_favorito'];
    
    //debería de validar si los campos están rellenos.
    setcookie('nombre', $nombre, time() + (30 * 24 * 60 * 60), "/"); // Duración 30 días
    setcookie('color_favorito', $color, time() + (30 * 24 * 60 * 60), "/"); // Duración 30 días
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir a la misma página para actualizar la visualización
    exit; // Terminar el script para evitar que el resto del código se ejecute
}
// Verificar si se ha solicitado eliminar cookies
elseif (isset($_POST['reset_nombre'])) {
    setcookie('nombre', "", time() - 3600, "/"); // Eliminar la cookie del nombre
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir a la misma página para actualizar la visualización
    exit; // Terminar el script para evitar que el resto del código se ejecute
} elseif (isset($_POST['reset_color'])) {
    setcookie('color_favorito', "", time() - 3600, "/"); // Eliminar la cookie del color
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir a la misma página para actualizar la visualización
    exit; // Terminar el script para evitar que el resto del código se ejecute
} 

// Recuperar las cookies si existen
if (isset($_COOKIE['nombre'])) {
    $nombre = $_COOKIE['nombre'];
}
if (isset($_COOKIE['color_favorito'])) {
    $color = $_COOKIE['color_favorito'];
}
?>

<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Gestión de Cookies</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>
<body>
    <header>
        <h2>Gestión de Cookies Múltiples</h2>
    </header>
    <main>
        <h3>Guardar Información</h3>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            <br>
            <label for="color_favorito">Color Favorito:</label>
            <input type="color" name="color_favorito" id="color_favorito" value="<?php echo htmlspecialchars($color); ?>" required>
            <br>
            <button type="submit" name="guardar">Guardar Cookies</button>
        </form>

        <h3>Cookies Almacenadas</h3>
        <?php
        // Mostrar las cookies si existen
        if (empty($nombre) && empty($color)) {
            echo "<p class='notice'>No hay cookies almacenadas.</p>";
        } else {
            if (!empty($nombre)) {
                echo "<p>Nombre: <strong>" . htmlspecialchars($nombre) . "</strong></p>";
                echo '<form method="post" action="">
                        <button type="submit" name="reset_nombre">Eliminar Cookie de Nombre</button>
                      </form>';
            }

            if (!empty($color)) {
                echo "<p>Color Favorito: <strong style='background-color: $color; color: white;'>$color</strong></p>";
                echo '<form method="post" action="">
                        <button type="submit" name="reset_color">Eliminar Cookie de Color Favorito</button>
                      </form>';
            }
        }
        ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>
</html>
