<!-- 
    Página de alta de libros de la Biblioteca Local
    Autor: P.Lluyot
    Examen-1 de DWES - Curso 2025-2026
-->
<?php
/* ############################## CÓDIGO PHP ################################################

# ================= APARTADO 1: Formulario y validación (2 puntos) ==========================
*/
$errores = [];
$mensaje = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $titulo = htmlspecialchars($_POST['titulo']??'');
    $autor = $_POST['autor']??'';
    $anio = $_POST['anio']??0;
    $genero = $_POST['genero']??'';

    if(empty($titulo)){
        $errores['titulo'] = "El titulo no puede estar vacio";
    }
    if(empty($autor)){
        $errores['autor'] = "El autor no puede estar vacio";
    }
    if(empty($anio)){
        $errores['anio'] = "El año no puede estar vacio";
    }elseif($anio < 1800 || $anio > 2100){
        $errores['anio'] = "El año debe estar comprendida entre 1800 y 2100";
    }
    if(empty($genero)){
        $errores['genero'] = "El genero no puede estar vacio";
    }
    /*

# ================= APARTADO 2: Grabación en fichero (1 punto) ============================== ************ */
    if(empty($errores)){
        $ruta = "libros.csv";
        $fichero = fopen($ruta , "a+");
        $datos = [$titulo, $autor, $anio, $genero, PHP_EOL];
        $contenido = implode( ";", $datos);
        fputs( $fichero , $contenido);
        fclose($fichero);
        $mensaje = "El libro ha sido registrado correctamente";

        // Vaciar los campos una vez registrado el libro

        $titulo = $autor = $genero = "";
        $anio = "";
        $errores = [];
    }
}

# ############################# FIN CÓDIGO PHP ############################################## */
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <!-- Hoja de estilos principal de simple.css -->
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <!-- Hoja de estilos personalizada para la biblioteca -->
    <link rel='stylesheet' href='css/biblioteca.css'>
</head>

<body>
    <!-- Cabecera de la página con título y menú de navegación -->
    <header>
        <h2>📚 Biblioteca Local</h2>
        <nav>
            <a href="index.php">🏠 Página principal</a>
            <a href="alta_libro.php" class="active">💾 Registrar libro</a>
            <a href="listado.php">📋 Listado de libros</a>
        </nav>
    </header>
    <!-- Contenido principal: formulario de alta de libros -->
    <main>
        <form method="POST">
            <p>
                <!-- Campo para el título del libro -->
                <label for="titulo">Título del libro</label>
                <input type="text" id="titulo" name="titulo" size="40" value="<?= $titulo ?>">
                <?php if(!empty($errores['titulo'])):?>
                <span class="error"><?= $errores['titulo'] ?></span>
                <?php endif; ?>

                <!-- Campo para el autor del libro -->
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" size="40" value="<?= $autor ?>">
                <?php if(!empty($errores['autor'])):?>
                <span class="error"><?= $errores['autor'] ?></span>
                <?php endif; ?>

                <!-- Campo para el año de publicación -->
                <label for="anio">Año de publicación</label>
                <input type="number" id="anio" name="anio" value="<?= $anio ?>">
                <?php if(!empty($errores['anio'])):?>
                <span class="error"><?= $errores['anio'] ?></span>
                <?php endif; ?>

                <!-- Campo para el género del libro -->
                <label for="genero">Género</label>
                <select id="genero" name="genero" >
                    <option value="">Selecciona un género</option>
                    <option value="Novela" <?= $genero == "Novela"? "selected" : "" ?>>Novela</option>
                    <option value="Ciencia ficción" <?= $genero == "Ciencia ficción"? "selected" : "" ?>>Ciencia ficción</option>
                    <option value="Fantasía" <?= $genero == "Fantasía"? "selected" : "" ?>>Fantasía</option>
                </select>
                <?php if(!empty($errores['genero'])): ?>
                <span class="error"><?= $errores['genero'] ?></span>
                <?php endif; ?>
            </p>
            <!-- Botón para enviar el formulario -->
            <button type="submit" name="registrar">
                💾 Registrar Libro
            </button>
        </form>
        <!-- Mensaje de notificación o resultado -->
         <?php if(!empty($mensaje)) :?>
        <p class='notice'><?= $mensaje ?></p>
        <?php endif; ?>
    </main>
    <!-- Pie de página -->
    <footer>
        <p><em>Examen-1 de DWES - Curso 2025-2026.</em></p>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>