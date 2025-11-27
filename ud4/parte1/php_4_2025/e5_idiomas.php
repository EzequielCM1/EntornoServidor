<?php
/**
* Ejercicio realizado por P.Lluyot. 2DAW
*/
// Inicializar el idioma
$idioma = $_COOKIE['idioma'] ?? 'es';
// Definición de los textos traducidos
$traducciones = [
    'es' => [
        'titulo' => 'Bienvenido a nuestra página',
        'descripcion' => 'Por favor, selecciona tu idioma preferido.',
        'selecciona_idioma' => 'Selecciona un idioma:',
        'enviar' => 'Enviar',
        'mensaje' => 'Has seleccionado Español.',
        'idioma' => 'Idiomas'
    ],
    'en' => [
        'titulo' => 'Welcome to our page',
        'descripcion' => 'Please select your preferred language.',
        'selecciona_idioma' => 'Select a language:',
        'enviar' => 'Submit',
        'mensaje' => 'You have selected English.',
        'idioma' => 'Languages'
    ]
];

// Cambiar el idioma si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idioma'])) {
    $idioma = $_POST['idioma'];

    // Verificar si el idioma existe en el array de traducciones.
    if (array_key_exists($idioma, $traducciones)) 
        setcookie('idioma', $idioma, time() + (86400 * 30), "/"); // 30 días
    else
        $idioma = 'es'; // Por defecto ponemos el español si el idioma no está definido. No genero la cookie.
    
}
?>
<?php
//código php
?>
<!DOCTYPE html>
<html lang="<?php echo $traducciones[$idioma]['idioma']; ?>">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo $traducciones[$idioma]['titulo']; ?></title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2><?php echo $traducciones[$idioma]['idioma']; ?></h2>
    </header>
    <main>
        <!-- código php -->
        <?php echo "<h2>{$traducciones[$idioma]['titulo']}</h2>"; ?>
        <?php echo "<p>{$traducciones[$idioma]['descripcion']}</p>"; ?>

        <form method="post" action="">
            <p>
                <label><?php echo $traducciones[$idioma]['selecciona_idioma']; ?></label>
                <select name="idioma">
                    <option value="es" <?php echo ($idioma == 'es') ? 'selected' : ''; ?>>Español</option>
                    <option value="en" <?php echo ($idioma == 'en') ? 'selected' : ''; ?>>English</option>
                    <option value="it" <?php echo ($idioma == 'it') ? 'selected' : ''; ?>>Italiani</option>
                </select>
            </p>
            <input type="submit" value="<?php echo $traducciones[$idioma]['enviar']; ?>">
        </form>
        <?php echo "<p class='notice'>{$traducciones[$idioma]['mensaje']}</p>"; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>