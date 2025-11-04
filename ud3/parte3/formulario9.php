<?php
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['generar'])) {
    $longitud = intval($_GET['longitud'] ?? 0);
    $minuscula = isset($_GET['minuscula']);
    $mayuscula = isset($_GET['mayuscula']);
    $numero = isset($_GET['numero']);
    $especial = isset($_GET['especial']);

    if ($longitud < 8 || $longitud > 16) {
        $mensaje = "La longitud debe estar entre 8 y 16.";
    } elseif (!$minuscula && !$mayuscula && !$numero && !$especial) {
        $mensaje = "Selecciona al menos un tipo de caracter.";
    } else {
        $caracteres = "";

        if ($minuscula) {
            $caracteres .= "abcdefghijklmnopqrstuvwxyz";
        }
        if ($mayuscula) {
            $caracteres .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        if ($numero) {
            $caracteres .= "0123456789";
        }
        if ($especial) {
            $caracteres .= "@#?¿!%";
        }

        $contrasenia = "";
        $maxIndex = strlen($caracteres) - 1;

        for ($i = 0; $i < $longitud; $i++) {
            $contrasenia .= $caracteres[rand(0, $maxIndex)];
        }
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
       <h1>Genera tu contraseña "Seguara"</h1>
   </header>
   <main>
       <form method="GET" action="">
           <p>
               <label for="longitud">Longitud:</label>
               <input type="number" min="8" max="16" name="longitud" id="longitud" value="<?= htmlspecialchars($longitud ?? '') ?>">
           </p>
           <p>
               <label for="minuscula">Minúsculas:</label>
               <input type="checkbox" name="minuscula" id="minuscula" <?= $minuscula ? 'checked' : '' ?>>
           </p>
           <p>
               <label for="mayuscula">Mayúsculas:</label>
               <input type="checkbox" name="mayuscula" id="mayuscula" <?= $mayuscula ? 'checked' : '' ?>>
           </p>
           <p>
               <label for="numero">¿Algún número?:</label>
               <input type="checkbox" name="numero" id="numero" <?= $numero ? 'checked' : '' ?>>
           </p>
           <p>
               <label for="especial">¿Algún carácter especial?:</label>
               <input type="checkbox" name="especial" id="especial" <?= $especial ? 'checked' : '' ?>>
           </p>
           <input type="submit" value="Generar" name="generar">
       </form>

       <?php if (!empty($mensaje)) : ?>
           <p class='notice'><?= htmlspecialchars($mensaje); ?></p>
       <?php endif; ?>

       <?php if (!empty($contrasenia)) : ?>
           <p class='notice'>Tu contraseña es: <br> <?= htmlspecialchars($contrasenia); ?></p>
       <?php endif; ?>
   </main>
   <footer>
       <p>Zequi</p>
   </footer>
</body>
</html>
