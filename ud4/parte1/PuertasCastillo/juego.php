<?php

    session_start();
    $usuario = "";
    $ronda = 0;
    $puntos = 0;
    $personajes = [
  'nombre' => [
    'Sir Montague', 'Lady Rowena', 'Milo el Mudo', 'Griselda la Roja',
    'Hugo el Herrero', 'Tilda la Panadera', 'Fray Martín', 'Doña Beatriz',
    'Iñigo de Valverde', 'Aldara la Curandera', 'Roldán el Juglar', 'Gunnar el Mercenario',
    'Catalina la Mercader', 'Bruno el Carpintero', 'Sofía la Herbolaria', 'Lope el Mensajero'
  ],
  'profesion' => [
    'panadero', 'mercader', 'juglar', 'espía', 'heraldo',
    'herrero', 'soldado', 'carpintero', 'médico', 'armero',
    'agricultor', 'monje', 'curandera', 'cazador', 'tabernero',
    'trovador', 'guardia', 'albañil', 'campesino', 'pregonero'
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


    if(!isset($_SESSION['usuario'])){
        header("Location: index.php");
        exit();
    }else{
        $usuario = $_SESSION['usuario'];
    }

    if($ronda > 5){
        header("Location: fin.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>

</style>
</head>

<body>
    <header>
        <h1>Juego del castillo</h1>
    </header>

    <main>
        <div>
            <ol>
                <li>Ronda : <?= $ronda?>/5</li>
                <li>Puntos: <?= $puntos?></li>
                <li></li>
                <form action="" method="post">
                    <table>
                        <tbody>
                            <tr>
                                <td>Nombre </td>
                                <td><?= $nombre?></td>
                            </tr>
                            <tr>
                                <td>Profesion </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="pasar">Dejar Pasar</button>
                    <button type="submit" name="rechazar">Rechazar entrada</button>
                </form>
            </ol>
        </div>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>