<?php

session_start();
$usuario = "";
$ronda = $_SESSION['ronda']?? 0;
$puntos = $_SESSION['puntos']?? 0;
$aciertos = $_SESSION['aciertos']?? 0;
$fallos = $_SESSION['fallos']?? 0;
$personajes = [
    'nombre' => [
        'Sir Montague',
        'Lady Rowena',
        'Milo el Mudo',
        'Griselda la Roja',
        'Hugo el Herrero',
        'Tilda la Panadera',
        'Fray Martín',
        'Doña Beatriz',
        'Iñigo de Valverde',
        'Aldara la Curandera',
        'Roldán el Juglar',
        'Gunnar el Mercenario',
        'Catalina la Mercader',
        'Bruno el Carpintero',
        'Sofía la Herbolaria',
        'Lope el Mensajero'
    ],
    'profesion' => [
        'panadero',
        'mercader',
        'juglar',
        'espía',
        'heraldo',
        'herrero',
        'soldado',
        'carpintero',
        'médico',
        'armero',
        'agricultor',
        'monje',
        'curandera',
        'cazador',
        'tabernero',
        'trovador',
        'guardia',
        'albañil',
        'campesino',
        'pregonero'
    ],
    'motivo' => [
        'trae pan para la cocina real',
        'desea comerciar con los nobles',
        'quiere cantar una balada',
        'busca refugio de una tormenta',
        'tiene un mensaje urgente del rey',
        'viene a ofrecer sus servicios de herrería',
        'requiere atención médica para un familiar',
        'trae tablones para reparar la puerta norte',
        'quiere vender hierbas y ungüentos',
        'trae víveres desde la aldea vecina',
        'dice haber visto bandidos cerca del puente',
        'pide acceso al archivo para investigar linajes',
        'trae una carta sellada para el castellano',
        'busca trabajo como centinela',
        'viene a entregar un tributo atrasado',
        'dice que persiguen lobos su ganado',
        'trae noticias de un convoy retrasado',
        'quiere audiencia para proponer un trato',
        'viene a bendecir la capilla del castillo',
        'reclama una deuda con la armería'
    ]
];
$nombre = $personajes['nombre'][array_rand($personajes['nombre'])];
$profesion = $personajes['profesion'][array_rand($personajes['profesion'])];
$motivo = $personajes['motivo'][array_rand($personajes['motivo'])];
$impostor = random_int(0, 1);


if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
} else {
    $usuario = $_SESSION['usuario'];
    $ronda = $_SESSION['ronda'];
}

if ($ronda >=5) {
    header("Location: fin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['accion'] == "pasar") {
    if ($impostor === 1) {
        $puntos -= 5;
        $fallos++;
    } else {
        $puntos += 10;
        $aciertos++;
    }

    $ronda++;
    $_SESSION['ronda'] = $ronda;
    $_SESSION['puntos'] = $puntos;
    $_SESSION['aciertos'] = $aciertos;
    $_SESSION['fallos'] = $fallos;
    header("Location: juego.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['accion'] == "rechazar") {
    if ($impostor === 1) {
        $puntos +=10;
        $aciertos++;
    } else {
        $puntos -=5;
        $fallos++;
    }
    $ronda++;
    $_SESSION['ronda'] = $ronda;
    $_SESSION['puntos'] = $puntos;
    $_SESSION['aciertos'] = $aciertos;
    $_SESSION['fallos'] = $fallos;
    header("Location: juego.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Turno <?= htmlspecialchars($turno) ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h1>Puertas del castillo</h1>
    <!-- Tabla de estadísticas del juego -->
    <table class="stats-table">
        <tr>
            <th>TURNO</th>
            <th>Puntos</th>
            <th>Aciertos</th>
            <th>Fallos</th>

        </tr>
        <tr>
            <td><?= $ronda ?> / 5</td>
            <td><?= $puntos ?></td>
            <td><?= $aciertos ?></td>
            <td><?= $fallos ?></td>
        </tr>
    </table>
    <h2>Personaje</h2>

    <table class="datos-table">
        <tr>
            <th>Nombre</th>
            <td><?= $nombre ?></td>
        </tr>
        <tr>
            <th>Profesión</th>
            <td><?= $profesion ?></td>
        </tr>
        <tr>
            <th>Motivo</th>
            <td><?= $motivo ?></td>
        </tr>
    </table>

    <form method="post" action="juego.php">
        <button name="accion" value="pasar">Dejar pasar</button>
        <button name="accion" value="rechazar">Rechazar entrada</button>
    </form>

    <p class="ok">El personaje era un impostor</p>
    <p class="ok">¡Correcto! Has ganado 10 puntos</p>

</body>

</html>