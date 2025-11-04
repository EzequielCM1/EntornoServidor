    <?php
    $traducciones = [
        'es' => [
            'titulo' => 'Esta es mi página web',
            'descripcion' => 'Por favor introduce tu idioma de preferencia',
            'label' => 'Selecciona un idioma',
            'boton' => 'Español',
            'traducir' => 'Traducir', // palabra para el botón
        ],
        'en' => [
            'titulo' => 'This is my website',
            'descripcion' => 'Please enter your preferred language',
            'label' => 'Select a language',
            'boton' => 'English',
            'traducir' => 'Translate',
        ],
        'fr' => [
            'titulo' => 'Ceci est mon site web',
            'descripcion' => 'Veuillez entrer votre langue préférée',
            'label' => 'Sélectionnez une langue',
            'boton' => 'Français',
            'traducir' => 'Traduire',
        ],
    ];

    $preferencia = "es"; // por defecto en español
    if (isset($_COOKIE['preferencia'])) $preferencia = $_COOKIE['preferencia'];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $elegido = $_POST['lengaje'] ?? '';

        if (array_key_exists($elegido, $traducciones)) {
            setcookie('preferencia', $elegido, time() + 3600);
            header("Location: ejercicio5.php");
            exit();
        }
    }

    $texto = $traducciones[$preferencia];
    ?>

    <!DOCTYPE html>
    <html lang="<?= htmlspecialchars($preferencia) ?>">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>cookies</title>
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    </head>

    <body>
        <header>
            <h1>Cookies idioma</h1>
        </header>

        <main>
            <h3><?= htmlspecialchars($texto['titulo']) ?></h3>
            <p><?= htmlspecialchars($texto['descripcion']) ?></p>
            <form action="" method="POST">
                <label for="label"><?= htmlspecialchars($texto['label']) ?></label>
                <select name="lengaje" id="lenguaje">
                    <option value="es" <?= $preferencia === 'es' ? 'selected' : '' ?>>es</option>
                    <option value="en" <?= $preferencia === 'en' ? 'selected' : '' ?>>en</option>
                    <option value="fr" <?= $preferencia === 'fr' ? 'selected' : '' ?>>fr</option>
                </select>
                <br>
                <p>Idioma actal : <?= htmlspecialchars($texto['boton']) ?></p>
                <button type="submit"><?= htmlspecialchars($texto['traducir']) ?></button>
            </form>
        </main>

        <footer>
            <p>Zequi</p>
        </footer>
    </body>

    </html>