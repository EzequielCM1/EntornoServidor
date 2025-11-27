<?php
/**
* Ejercicio realizado por P.Lluyot. 2DAW
*/
$contenido="";

// Función para leer un archivo y cargar los productos en un array bidimensional
function cargarProductosDesdeArchivo($fichero) {
    $listaProductos = [];  // Inicializa un array vacío para almacenar los productos
    // Si el fichero no existe, retorna el array vacío
    if (!file_exists($fichero)){
        return $listaProductos;
    }
    // Abre el archivo en modo de solo lectura ("r")
    if (($manejador = fopen($fichero, "r")) !== FALSE) {
        // Lee el archivo línea por línea
        while (($linea = fgets($manejador)) !== FALSE) {
            // Divide cada línea del archivo en sus partes: ID, Nombre, Precio, Cantidad
            $datosProducto = explode("|", trim($linea));
            // Verifica si la línea tiene exactamente 4 partes (ID, Nombre, Precio, Cantidad)
            if (count($datosProducto) == 4) {
                // Añade los datos del producto al array
                $listaProductos[] = [
                    'ID' => $datosProducto[0],              // ID del producto
                    'Nombre' => $datosProducto[1],          // Nombre del producto
                    'Precio' => (float) $datosProducto[2],  // Precio convertido a número flotante
                    'Cantidad' => (int) $datosProducto[3]   // Cantidad convertida a número entero
                ];
            }else{
                //si hay error en un dato devolvemos el array vacío
                return [];
            }

        }
        // Cierra el archivo después de leer
        fclose($manejador);
    }

    // Retorna el array con todos los productos cargados
    return $listaProductos;
}


// Función para generar una tabla HTML a partir de un array bidimensional
function tablaArrayHTML($arrayBidimensional)
{
    // Si el array está vacío, retorna una cadena vacía
    if (empty($arrayBidimensional)) return "Error: El array está vacío.";

    // Obtener el número de columnas de la primera fila
    $numeroColumnas = count($arrayBidimensional[0]);

    // Inicializar la cadena de texto para la tabla HTML
    $tablaHTML = "<table border='1'>\n<tr>"; // Comenzar la tabla y primera fila de cabecera

    // Crear las cabeceras de la tabla usando los índices del primer elemento
    foreach ($arrayBidimensional[0] as $indice => $valor) {
        // Escapar los valores para evitar problemas de seguridad (XSS)
        $tablaHTML .= "<th>" . htmlspecialchars($indice) . "</th>";
    }

    $tablaHTML .= "</tr>\n"; // Cerrar la fila de cabecera

    // Recorrer cada fila del array bidimensional
    foreach ($arrayBidimensional as $fila) {
        // Comprobar si el número de columnas de la fila coincide con la primera fila
        if (count($fila) != $numeroColumnas) {
            // Retornar error si el número de columnas no coincide
            return "Error: Diferente número de columnas en una fila.";
        }

        $tablaHTML .= "<tr>"; // Iniciar una nueva fila

        // Recorrer cada valor de la fila
        foreach ($fila as $valor) {
            // Escapar los valores para mayor seguridad
            $tablaHTML .= "<td>" . htmlspecialchars($valor) . "</td>";
        }

        $tablaHTML .= "</tr>\n"; // Cerrar la fila actual
    }

    $tablaHTML .= "</table>"; // Cerrar la tabla

    // Devolver la tabla HTML generada
    return $tablaHTML;
}

// Main
$archivo = 'productos.txt';
$productos = cargarProductosDesdeArchivo($archivo);
if (!empty($productos)) {

    //echo "<pre>".print_r ($productos,true)."</pre>";
    
    //imprimirProductos($productos);
    $contenido= tablaArrayHTML($productos);
    
} else {
    $contenido = "No se encontraron productos en el archivo.";
}
?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>
<body>
    <header><h2>Tabla de productos</h2></header>
    <main>
        <!-- código php -->
        <?php
         if(!empty($contenido)) echo $contenido;
        ?>
       
    </main>
    <footer><p>P.Lluyot</p></footer>
</body>
</html>