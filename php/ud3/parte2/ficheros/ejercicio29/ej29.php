<?php
$mensaje = "";
$archivo = "cifrados.txt";


if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
   
    $texto = $_POST['texto']??'';
    $desplazar = htmlspecialchars($_POST['desplazar']?? 0);

    $alfabeto = "abcdefghijklmnñopqrstuvwxyz";

    //Lo convierto en un array
    $arrytexto = mb_str_split($texto);

    function cifrarTexto($contenido ,$numero, $alfabeto) {
        $resultado ="";
        $arryalfabeto = mb_str_split($alfabeto);
        $longitud = count($arryalfabeto);

        foreach($contenido as $letra){
            $posicion = array_search($letra, $arryalfabeto);

        if ($posicion !== false) {

            $nuevaPos = ($posicion + $numero) % $longitud;
            // En caso de número negativo
            if ($nuevaPos < 0) $nuevaPos += $longitud;
            $resultado .= $arryalfabeto[$nuevaPos];
        } else {
            // Si no está en el alfabeto, dejamos el carácter igual
            $resultado .= $letra;
        }
        }


        return $resultado;
    }

    function guardar($textCifrado, $archivo){
        
        $guardar = file_put_contents($archivo, $textCifrado);

        if ($guardar === false) {
        return "Error al guardar en el archivo.";
            } else {
        return "Texto guardado correctamente en $archivo.";
            }

    }


    
    if(empty($texto)){
        $mensaje = "Debes poner texto";
    }elseif(empty($desplazar)){
        $mensaje = "Indica cuanto quieres que se desplacen";
    }elseif(!file_exists($archivo)){
        $mensaje = "No existe el fichero";
    }else{
        $mensaje = cifrarTexto($arrytexto, $desplazar, $alfabeto);
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
       <h1>Cifrado de Julio Cesar</h1>
   </header>
   <main>
       <form method="POST" action="">
           <p>
               <label for="texto">Texto</label>
               <input type="text" name="texto" id="texto">
           </p>
           <p>
                <label for="number">Numero de Dezplazamiento</label>
                <input type="number" name="desplazar" id="desplazar">
           </p>

           <p>
            <button type="submit" name="accion" value="cifrar">Cifrar</button>
            <button type="submit" name="accion" value="guardar">Guardar</button>
            </p>

         
       </form>
       <?php if (!empty($mensaje)) : ?>
           <p class='notice'><?= htmlspecialchars($mensaje); ?></p>
       <?php endif; ?>
        <pre>
            <?php
                print_r($arrytexto);
            ?>
        </pre>
   </main>
   <footer>
       <p>Zequi</p>
   </footer>
</body>
</html>
