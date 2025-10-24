<?php
$mensaje = "";
$errores = [];
$palabrasOrdenadas = [];
$extencionPermitida = "txt";

$nombre = $_POST['nombre'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar el nombre
    if (empty($nombre)) {
        $errores["nombre"] = "El nombre debe contener texto";
    } elseif (strlen($nombre) < 3 || strlen($nombre) > 30) {
        $errores["nombre"] = "El nombre debe tener entre 3 y 30 caracteres";
    } else {
        // Limpiar el nombre para evitar caracteres no válidos
        $nombre = preg_replace('/[^a-zA-Z0-9_-]/', '', $nombre);
        if ($nombre === '') {
            $errores["nombre"] = "El nombre contiene caracteres no permitidos";
        }
    }

    // Validar archivo
    if (isset($_FILES['fichero'])) {
        $archivo = $_FILES['fichero'];
        $extencion = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errores["archivo"] = "Error en la subida del archivo.";
        } else {
            if ($extencion !== $extencionPermitida) {
                $errores["archivo"] = "La extensión del archivo debe ser .txt";
            }
            if ($archivo['size'] > 100) {
                $errores["archivo"] = "El archivo no debe superar 100 bytes";
            }
        }
    } else {
        $errores["archivo"] = "Debe subir un archivo txt";
    }

    // Si no hay errores, comprobar contenido del archivo
    if (empty($errores)) {
        $contenido = file_get_contents($archivo['tmp_name']);
        $palabras = array_map('trim', explode(',', $contenido));

        if (count($palabras) !== 5) {
            $errores["contenido"] = "El archivo debe contener exactamente 5 palabras separadas por coma";
        } else {
            // Verificar que no haya palabras vacías
            foreach ($palabras as $p) {
                if ($p === '') {
                    $errores["contenido"] = "Las palabras no pueden estar vacías";
                    break;
                }
            }
        }
    }

    // Si todo correcto, guardar el archivo
    if (empty($errores)) {

        $rutaArchivo = "upload/" . $nombre . ".txt";

        // Verificar que no exista previamente
        if (file_exists($rutaArchivo)) {
            $errores["existe"] = "El archivo con ese nombre ya existe";
        } else {
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                $mensaje = "Archivo subido correctamente.";

                // Ordenar las palabras alfabéticamente para mostrar
                $palabrasOrdenadas = $palabras;
                sort($palabrasOrdenadas, SORT_STRING | SORT_FLAG_CASE);
            } else {
                $errores["subida"] = "Error al guardar el archivo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subida de archivo con palabras</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>
        .error {
            color: red;
            font-size: 0.9rem;
        }

        .success {
            color: green;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Subida de archivo con palabras</h1>
    </header>

    <main>
        <form method="POST" enctype="multipart/form-data" action="">
            <p>
                <label for="nombre">Nombre del archivo (3-30 caracteres):</label><br />
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required />
                <?php if (!empty($errores['nombre'])) : ?>
                    <br /><span class="error"><?= $errores['nombre'] ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="fichero">Archivo txt con 5 palabras separadas por coma (máximo 100 bytes):</label><br />
                <input type="file" id="fichero" name="fichero" accept=".txt" required />
                <?php if (!empty($errores['archivo'])) : ?>
                    <br /><span class="error"><?= $errores['archivo'] ?></span>
                <?php endif; ?>
                <?php if (!empty($errores['contenido'])) : ?>
                    <br /><span class="error"><?= $errores['contenido'] ?></span>
                <?php endif; ?>
                <?php if (!empty($errores['existe'])) : ?>
                    <br /><span class="error"><?= $errores['existe'] ?></span>
                <?php endif; ?>
                <?php if (!empty($errores['subida'])) : ?>
                    <br /><span class="error"><?= $errores['subida'] ?></span>
                <?php endif; ?>
            </p>

            <button type="submit">Subir archivo</button>
        </form>

        <?php if ($mensaje) : ?>
            <p class="success"><?= $mensaje ?></p>
        <?php endif; ?>

        <?php if (!empty($palabrasOrdenadas)) : ?>
            <h2>Palabras ordenadas alfabéticamente:</h2>
            <ul>
                <?php foreach ($palabrasOrdenadas as $palabra) : ?>
                    <li><?= htmlspecialchars($palabra) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>
