<?php
$contenido = "";
$archivo = 'productos.txt';

// Función para cargar los productos desde el archivo
function cargarProductosDesdeArchivo($archivo) {
    $productos = [];

    if (!$handle = fopen($archivo, "r")) {
        return [];
    }

    while (($linea = fgets($handle)) !== false) {
        $partes = explode('|', trim($linea));
        if (count($partes) === 4) {
            $productos[] = [
                'ID' => $partes[0],
                'Nombre' => $partes[1],
                'Precio' => $partes[2],
                'Cantidad' => $partes[3]
            ];
        }
    }

    fclose($handle);
    return $productos;
}

function tablaArrayHTML($array) {
    if (empty($array)) return "<p>No hay datos para mostrar.</p>";

    $tabla = "<table>\n<thead><tr>";

    // Filas de datos
    foreach ($array as $fila) {
        $tabla .= "<tr>";
        foreach ($fila as $valor) {
            $tabla .= "<td>" . htmlspecialchars($valor) . "</td>";
        }
        $tabla .= "</tr>\n";
    }

    $tabla .= "</tbody></table>\n";
    return $tabla;
}

// Lógica principal
if (!file_exists($archivo)) {
    $contenido = "El fichero no existe.";
} else {
    $productos = cargarProductosDesdeArchivo($archivo);
    if (!empty($productos)) {
        $contenido = tablaArrayHTML($productos);
    } else {
        $contenido = "El archivo no contiene productos válidos.";
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
       <h1>Manejo de ficheros 28</h1>
   </header>
   <main>
       <?= $contenido ?>
   </main>
   <footer>
       <p>Zequi</p>
   </footer>
</body>
</html>
