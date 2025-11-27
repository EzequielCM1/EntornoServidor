<?php
session_start();
require_once "funciones_csv.php";

if (isset($_GET['index'])) {
    $index = intval($_GET['index']);

    // Comprobar si existe en sesión
    if (isset($_SESSION['reservas'][$index])) {

        // Guardamos el ID ANTES de eliminarlo de la sesión
        $idReserva = $_SESSION['reservas'][$index];

        // 1️⃣ Primero eliminar del CSV
        eliminarReservaCSV($idReserva);

        // 2️⃣ Ahora sí eliminamos de la sesión
        unset($_SESSION['reservas'][$index]);
        $_SESSION['reservas'] = array_values($_SESSION['reservas']); // Reindexar

        // Mensaje flash
        $_SESSION['flash_message'] = "Reserva eliminada correctamente.";
    }
}

header("Location: verReservas.php");
exit();
