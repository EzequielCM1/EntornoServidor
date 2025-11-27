<?php
// ========================================================================================
// ACTIVIDAD PRÁCTICA: SISTEMA DE RESERVA DE CINE (CINE DWES)
// diseñada por P.Lluyot-2025
// ========================================================================================

// ----------------------------------------------------------------------------------------
// Definición de constantes y variables
// ----------------------------------------------------------------------------------------
// Define aquí las constantes para el número de filas y asientos.
$filas = 5;
$asientos = 8;
// Inicializa aquí las variables que necesitarás a lo largo del script
$nombre = "";
$mensajeEr = "";
$mensajeEx = "";
$ruta = "reservas.csv";
// ----------------------------------------------------------------------------------------
// Definición de funciones
// ----------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------
// LÓGICA PRINCIPAL DE LA APLICACIÓN
// ----------------------------------------------------------------------------------------

// 1. Inicialización: Implementa la lógica necesaria para crear y gestionar la matriz de estado bidimensional de la sala. ($asientos)
$sala = [];

for ($i = 1; $i <= $filas; $i++) {
    for ($a = 1; $a <= $asientos; $a++) {
        $sala[$i][$a] = 0;
    }
}
// 2. Carga de Persistencia: Carga las reservas existentes para tener el estado actualizado.
if (file_exists($ruta)) {
    $fichero = fopen($ruta, "r");
    while (($linea = fgetcsv($fichero)) !== false) {
        list($fila, $asiento, $nombre) = $linea;
        $sala[$fila][$asiento] = 1;
    }
    fclose($fichero);
}
// 3. Procesa los datos del formulario.
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['asiento'])) {
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));

    if (empty($nombre)) {
        $mensajeEr = "El nombre no puede estar vacio";
    }

    if (empty($mensajeEr)) {
        list($filaO, $asientoO) = explode("-", $_POST['asiento']);

        if ($sala[$filaO][$asientoO] == 1) {
            $mensajeEr = "Ese asiento ya está reservado";
        } else {
            $sala[$filaO][$asientoO] = 1;

            // guardamos en el fichero 
            $fichero = fopen($ruta, "a");
            fputcsv($fichero, [$filaO, $asientoO, $nombre]);
            fclose($fichero);

            $mensajeEx = "Reserva registrada ";

        }
    }
}
// 4. Calcula las estadísticas finales para mostrarlas en la página.
$ocupados = 0;
$total = $filas * $asientos;

for ($f = 1; $f <= $filas; $f++) {
    for ($a = 1; $a <= $asientos; $a++) {
        if ($sala[$f][$a] == 1) $ocupados++;
    }
}

$libres = $total - $ocupados;
$porcentaje = round(($ocupados / $total) * 100);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine DWES - Reservas</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="css/cine.css"> <!-- hoja de estilos que complementa simple.css -->
</head>

<body>
    <!-- cabecera -->
    <header>
        <h1>🎬 Cine DWES</h1>
        <!-- APARTADO 1: Muestra aquí dinámicamente el tamaño de la sala -->
        <p>Sistema de Reservas (2 Filas x 4 Asientos)</p><!-- cambia el 2 y 4 por el valor de la constante -->
    </header>
    <!-- parte principal de la web -->
    <main>
        <h3>Reserva de asientos</h3>

        <!-- APARTADO 3: Inserta aquí el código PHP para mostrar los mensajes de error o éxito -->
        <!--
        <p class="notice error">Mensaje de error</p>
        <p class="notice exito">Mensaje informativo</p>
        -->
        <?php
        if (!empty($mensajeEr)) { ?>
            <p class="notice error"><?= $mensajeEr ?></p>
        <?php } elseif (!empty($mensajeEx)) { ?>
            <p class="notice exito"><?= $mensajeEx ?></p>
        <?php }  ?>


        <!-- APARTADO 2: El formulario debe enviar los datos por POST a este mismo fichero -->
        <form class="form-reserva" method="post">
            <label for="nombre">Tu Nombre:</label>
            <!-- APARTADO 2: Asegúrate de que este campo conserve el valor si la reserva falla -->
            <input type="text" id="nombre" name="nombre" size="35" placeholder="Introduce tu nombre completo">

            <div class="pantalla">PANTALLA</div>

            <div class="sala">

                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <?php for ($a = 1; $a <= $asientos; $a++): ?>
                                <th>A<?= $a ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php for ($f = 1; $f <= $filas; $f++): ?>
                            <tr>
                                <th>Fila <?= $f ?></th>

                                <?php for ($a = 1; $a <= $asientos; $a++): ?>

                                    <?php if ($sala[$f][$a] == 1): ?>
                                        <!-- asiento ocupado -->
                                        <td>
                                            <span class="asiento ocupado" title="Asiento Ocupado">
                                                <img src="img/sillon_ocupado.svg" alt="asiento">
                                            </span>
                                        </td>

                                    <?php else: ?>
                                        <!-- asiento libre -->
                                        <td>
                                            <button type="submit"
                                                name="asiento"
                                                value="<?= $f . '-' . $a ?>"
                                                class="asiento libre"
                                                title="Asiento Libre">
                                                <img src="img/sillon_libre.svg" alt="asiento">
                                            </button>
                                        </td>

                                    <?php endif; ?>

                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>

            </div>

        </form>
        <p class="info">
            Introduce tu nombre y selecciona un asiento libre.
        </p>

        <!-- APARTADO 4: Muestra aquí las estadísticas calculadas dinámicamente -->
        <section class="estadisticas">
            <h3>Estadísticas de la Sala</h3>
            <ul>
                <li>Asientos Ocupados: <strong><?=  $ocupados ?></strong></li>
                <li>Asientos Disponibles: <strong><?= $libres ?></strong></li>
                <li>Porcentaje de Ocupación: <strong><?= $porcentaje ?>%</strong></li>
            </ul>
        </section>

        <!-- APARTADO 5: Formulario para la funcionalidad de vaciado de sala -->
        <section class="administracion">
            <h4>Administración</h4>
            <form>
                <button type="submit" value="vaciar" class="btn-peligro">Vaciar Sala</button>
            </form>
        </section>
    </main>
    <!-- pie de página -->
    <footer>
        <p>Desarrollo Web en Entorno Servidor - Examen Práctico - P.Lluyot</p>
    </footer>
</body>

</html>