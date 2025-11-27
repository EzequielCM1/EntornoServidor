<?php
//inicializamos las variables
$mensaje = "";

//recuperamos del formulario los campos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['analizar']=='analizar') {
    $texto = $_POST['texto'] ?? '';

    if (empty($texto)) {
       $mensaje = "debe contener texto";
    }elseif (strlen($texto)> 500) {
        $mensaje = "El texto es demasiado largo";
    }else{
        /// Analicis 
        $longitud = strlen($texto);
        $palabras = str_word_count($texto); // SIRVE PARA CONTAR LAS PALABRAS
        $lineas = substr_count($texto, "\n") + 1;

         // Contar vocales
            $vocales = [
                'a' => substr_count(strtolower($texto), 'a'),
                'e' => substr_count(strtolower($texto), 'e'),
                'i' => substr_count(strtolower($texto), 'i'),
                'o' => substr_count(strtolower($texto), 'o'),
                'u' => substr_count(strtolower($texto), 'u')
            ];

            // Porcentaje de espacios
            $espacios = substr_count($texto, " ");
            $porcentaje = ($espacios / strlen($texto)) * 100; 

        $resultado = "
            <div class='resultado'>
            <h2>Resultados del analisis</h2>
            <p>Longitud del texto: $longitud</p>
            <p>Numero de palabras: $palabras</p>
            <p>Numero de líneas: $lineas</p>
                <p>Frecuencia de vocales:</p>
                <ul>
                    <li>A: {$vocales['a']}</li>
                    <li>E: {$vocales['e']}</li>
                    <li>I: {$vocales['i']}</li>
                    <li>O: {$vocales['o']}</li>
                    <li>U: {$vocales['u']}</li>
                </ul>
            <p>Porcentaje de espacios:".number_format($porcentaje,2)."</p>
            </div>
        ";
    }

    


}

?>
<!DOCTYPE html>
<html lang='es'>


<head>
   <meta charset='UTF-8'>
   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <title>Zequi</title>
   <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>


<body>


   <header>
       <h1>Ejercicio analisis contenido texto</h1>
   </header>
   <main>
       <h2>Texto</h2>
       <form method="POST" action="">
           <p>
               <label for="texto">Texto:</label>
               <textarea name="texto" id="texto"></textarea>
           </p>
           <input type="submit" value="analizar" name="analizar">
       </form>
       <?php if (!empty($mensaje)) : ?>
           <p class='notice'><?= $mensaje; ?></p>
       <?php endif; ?>
       <?php if (!empty($resultado)) : ?>
           <p class='notice'><?= $resultado; ?></p>
       <?php endif; ?>
   </main>
   <footer>
       <p>Zequi</p>
   </footer>
</body>
</html>