<?php

// Ruta del archivo CSV
define("ARCHIVO_RESERVAS", "reservas.csv");


// ================================
// GUARDAR RESERVA EN CSV
// ================================
function guardarReservaCSV($idReserva, $viajes)
{
    if (!isset($viajes[$idReserva])) {
        return false;
    }

    $v = $viajes[$idReserva];

    $linea = implode(";", [
        $idReserva,
        $v["destino"],
        $v["pais"],
        $v["precio"],
        $v["duracion"]
    ]) . PHP_EOL;

    file_put_contents(ARCHIVO_RESERVAS, $linea, FILE_APPEND);
    return true;
}



// ================================
// ELIMINAR RESERVA POR ID DEL CSV
// ================================
function eliminarReservaCSV($idReserva)
{
    if (!file_exists(ARCHIVO_RESERVAS)) {
        return false;
    }

    $lineas = file(ARCHIVO_RESERVAS, FILE_IGNORE_NEW_LINES);

    $nuevasLineas = [];

    foreach ($lineas as $linea) {
        $partes = explode(";", $linea);

        // Si la línea NO corresponde a la reserva que queremos eliminar, la guardamos
        if ($partes[0] != $idReserva) {
            $nuevasLineas[] = $linea;
        }
    }

    // Reescribir archivo sin la línea eliminada
    file_put_contents(ARCHIVO_RESERVAS, implode(PHP_EOL, $nuevasLineas) . PHP_EOL);

    return true;
}
?>
