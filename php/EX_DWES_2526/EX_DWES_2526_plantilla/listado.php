<!-- 
    Página de listado de libros de la Biblioteca Local
    Autor: P.Lluyot
    Examen-1 de DWES - Curso 2025-2026
-->
<?php
/* ############################## CÓDIGO PHP ################################################
*/

# ================= Apartado 3: Lectura de fichero y generación de tabla (2 puntos) ==========
# - Lee los datos de libros.csv y genera la tabla HTML con los libros registrados.


# ================= Apartado 4: Funciones PHP (1 punto) ======================================
# - Implementa funciones auxiliares para cargar libros y generar la tabla.
$mensaje = "";
$fichero = "libros.csv"; //declaro la ruta
$datos = [ // esto es un array de prueba
    ["titulo" => "titulo", "autor" => "Autor", "anio" => "Año", "genero" => "genero"],
    ["titulo" => "hola", "autor" => "Luis", "anio" => "1800", "genero" => "Novela"],
    ["titulo" => "hola", "autor" => "Luis", "anio" => "1800", "genero" => "Ciencia ficción"]
    ];
function cargarLibros ($archivo){
    
    $fichero = fopen($archivo , "r");
    $array = [];
    // $array = str_getcsv($fichero, escape: ";");
    fclose($fichero);
    
}

function generarTabla ($arrayBidimensional,$titulo){
    
    echo "<table>";
    foreach ($arrayBidimensional as $dato){
        
        if($dato['genero'] == $titulo){
        echo "<tr>";
        echo '<td>'.$dato["titulo"].'</td>';
        echo '<td>'.$dato["autor"].'</td>';
        echo '<td>'.$dato["anio"].'</td>';
        echo '<td>'.$dato["genero"].'</td>';
        echo "</tr>";
        }elseif($titulo == "Todos" || $titulo == ""){
            echo "<tr>";
            echo '<td>'.$dato["titulo"].'</td>';
        echo '<td>'.$dato["autor"].'</td>';
        echo '<td>'.$dato["anio"].'</td>';
        echo '<td>'.$dato["genero"].'</td>';
        echo "</tr>";
        }

        /*
        <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Género</th>
                </tr>
            </thead>
        */ 
        
        
    }
    echo "</table>";
}
# ================= Apartado 5: Filtro por género (1,5 puntos) ===============================
# - Permite filtrar los libros por género mediante un formulario GET.

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $opcionGenero = $_GET['genero']??'';
    cargarLibros($fichero);
}

# ================= Apartado 6: Estadísticas (1,5 puntos) ====================================
# - Calcula y muestra el total de libros y el número de libros por género.

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
            <a href="alta_libro.php">💾 Registrar libro</a>
            <a href="listado.php" class="active">📋 Listado de libros</a>
        </nav>
    </header>
    <!-- Contenido principal: listado y filtrado de libros -->
    <main>
        <!-- ================= Apartado 5: Formulario de filtrado por género ================ -->
        <form method="GET">
            <label for="genero">Filtrar por género:</label>
            <select id="genero" name="genero">
                <option value="Todos">Todos</option>
                <option value="Novela">Novela</option>
                <option value="Ciencia ficción">Ciencia ficción</option>
                <option value="Fantasía">Fantasía</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        
        <!-- ================= Apartado 3: Tabla HTML de libros ============================= -->
        <?= 
        generarTabla($datos,$opcionGenero);
        ?>
        <!-- Mensaje de notificación o resultado -->
          <?php if(!empty($mensaje)) :?>
        <p class='notice'><?= $mensaje ?></p>
        <?php endif; ?>

        <!-- ================= Apartado 6: Estadísticas de libros ========================== -->
        <!--<p class='notice'><strong>Total de libros registrados</strong>: 34<br>
            - NombreGénero: 10<br>
            - NombreGénero: 24</p>
        -->
    </main>
    <!-- Pie de página con información del examen y autor -->
    <footer>
        <p><em>Examen-1 de DWES - Curso 2025-2026.</em></p>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>