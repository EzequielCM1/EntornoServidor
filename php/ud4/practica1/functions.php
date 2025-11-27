<?php

function iniciarJuego()
{

    $_SESSION['juego']['palabra'] = palabra_aleatoria();
    $_SESSION['juego']['progreso'] = str_repeat("_", strlen($_SESSION['juego']['palabra']));
    $_SESSION['juego']['usadas'] = [];
    $_SESSION['juego']['errores'] = 0;
    $_SESSION['juego']['turno'] = 1;

    $_SESSION['juego']['palabraMostrada'] = reemplazar_palabra_guiones($_SESSION['juego']['palabra']);
}

function palabra_aleatoria()
{
    $lista = [
        'ordenador',
        'programacion',
        'algoritmo',
        'variable',
        'servidor',
        'pantalla',
        'juego',
        'teclado',
        'funcion',
        'sesion',
        'desarrollo',
        'internet',
        'robot',
        'computadora',
        'software'
    ];

    $elegido = array_rand($lista);
    return $lista[$elegido];
}

function reemplazar_palabra_guiones($palabra)
{
    $resultado = "";

    for ($i = 0; $i < strlen($palabra); $i++) {
        $resultado .= "_";
    }
    return trim($resultado);
}

function procesarLetra($letra)
{
    $letra = strtolower($letra);

    if (in_array($letra, $_SESSION['juego']['usadas'])) {
        return "la letra ( $letra ) ya ha sido usada ";
    }

    $_SESSION['juego']['usadas'][] = $letra;
    $_SESSION['juego']['turno']++;
    $palabra = $_SESSION['juego']['palabra'];
    $progreso  = $_SESSION['juego']['progreso'];
    $acierto = false;

    /* revisar si esta en la plabra la letra */
    for ($i = 0; $i < strlen($palabra); $i++) {
        if ($palabra[$i] === $letra) {
            $progreso[$i] = $letra;
            $acierto = true;
        }
    }
    $_SESSION['juego']['progreso'] = $progreso;
    $_SESSION['juego']['palabraMostrada'] = implode(" ", str_split($progreso));


    if (!$acierto) {
        $_SESSION['juego']['errores']++;
        return "La letra ( $letra ) no se encuentra en la palabra";
    } else {
        return "La letra ( $letra ) si esta en la palabra";
    }
}

function victoria()
{
    return $_SESSION['juego']['progreso'] === $_SESSION['juego']['palabra'];
}

function derrota()
{
    return $_SESSION['juego']['errores'] >= 6;
}
