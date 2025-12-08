<!-- 
    Página de análisis del equipo de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
-->
<?php
session_start();
//recogemos los  datos de datos.php
require_once './datos.php';

if (!isset($_SESSION['jugador'])) {
    header("Location: index.php");
    exit();
}
//variable de todos los jugadores reclutados
$reclutados = $_SESSION['equipo'] ?? [];

//Estadisticas globales
$costeTotal = $_SESSION['costeTotal'] ?? 0;
$ataque = 0;
$defensa = 0;
$magia = 0;

$caballeros = 0;
$arquero = 0;


$clases = []; // array asociativo para contar clases
$equipo_contador = count($reclutados);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis del Equipo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-800">

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- cabecera y botón volver -->
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Análisis del Equipo</h1>
                <p class="text-slate-500">Resumen y estadísticas del equipo formado por <span class="font-semibold text-indigo-600"><!-- Nombre del estratega --></span>.</p>
            </div>
            <a href="equipo.php" class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700">Volver a la Gestión</a>
        </header>

        <!-- SECCIÓN: EQUIPO FINAL -->
        <section class="mb-10">
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Composición del Equipo Final</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">

                <?php foreach ($reclutados as $idHeroe): ?>
                    <?php
                    // Recuperamos el héroe real desde la constante HEROES
                    $heroe = HEROES[$idHeroe];

                    // Sumar estadísticas
                    $ataque += $heroe['ataque'];
                    $defensa += $heroe['defensa'];
                    $magia += $heroe['magia'];


                    $clase = $heroe['clase'];
                    if (!isset($clases[$clase])) {
                        $clases[$clase] = 0;
                    }
                    $clases[$clase]++;

                    ?>
                    <!-- Tarjeta de Héroe -->
                    <div class="rounded-lg shadow-lg overflow-hidden relative group ring-4 ring-offset-1 ring-indigo-500">
                        <img class="w-full h-full object-cover" src="img/<?= $heroe['imagen'] ?>" alt="Shadow">
                        <div class="absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out">
                            <div class="p-4 bg-black/40 transition duration-300 group-hover:bg-black/50 rounded-lg">
                                <h3 class="text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1"><?= $heroe['nombre'] ?></h3>
                                <p class="text-base font-medium text-indigo-200 mb-2"><?= $heroe['clase'] ?></p>
                                <div class="text-xs space-y-1">
                                    <p><strong>Ataque:</strong> <?= $heroe['ataque'] ?></p>
                                    <p><strong>Defensa:</strong> <?= $heroe['defensa'] ?></p>
                                    <p><strong>Magia:</strong> <?= $heroe['magia'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($reclutados)): ?>
                    <div class="col-span-full bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p>No hay héroes en el equipo para analizar.</p>
                    </div>
                <?php endif; ?>

            </div>
        </section>

        <!-- SECCIÓN: ESTADÍSTICAS GLOBALES-->
        <section>
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Estadísticas Globales</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Coste Total del Equipo</h3>
                    <p class="text-4xl font-bold text-indigo-600 mt-2"><?= $costeTotal ?> Puntos</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Ataque / Defensa / Magia Total</h3>
                    <p class="text-2xl font-bold mt-2">ATK: <?= $ataque ?></p>
                    <p class="text-2xl font-bold mt-1">DEF: <?= $defensa ?></p>
                    <p class="text-2xl font-bold mt-1">MAG: <?= $magia ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Promedio por Miembro</h3>
                    <?php
                    $promedioAtaque = $equipo_contador > 0 ? round($ataque / $equipo_contador) : 0;
                    $promedioDefensa = $equipo_contador > 0 ? round($defensa / $equipo_contador) : 0;
                    $promedioMagia = $equipo_contador > 0 ? round($magia / $equipo_contador) : 0;
                    ?>
                    <p class="text-md font-semibold mt-2">Ataque Promedio: <?= $promedioAtaque ?></p>
                    <p class="text-md font-semibold mt-1">Defensa Promedio: <?= $promedioDefensa ?></p>
                    <p class="text-md font-semibold mt-1">Magia Promedio: <?= $promedioMagia ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase text-center mb-3">Recuento por Clase</h3>

                    <ul class="space-y-2 text-center">
                        <?php foreach ($clases as $clase => $cantidad): ?>
                            <li class="font-semibold">
                                <?= $clase ?>
                                <span class="font-bold text-indigo-600 text-lg"><?= $cantidad ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

        </section>

    </div>

</body>

</html>