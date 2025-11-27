<?php
session_start();
require_once '../dataset.php';

$mensaje = "";
if (isset($_SESSION['flash_message'])) {
    $mensaje = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// Asegurar que exista el array de reservas
if (!isset($_SESSION['reservas'])) {
    $_SESSION['reservas'] = [];
}

// Array de reservas hechas → cada uno es un ID del dataset
$reservasHechas = $_SESSION['reservas'];

$reservas_count = count($reservasHechas);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas realizadas</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <header>
        <h1>Reservas hechas</h1>

        <div class="counter">
            Viajes reservados: <?= $reservas_count ?><br><br>
            <a href="./index.php" class="btn-select">Ve Vuelos</a>
        </div>
    </header>

    <?php if (!empty($mensaje)) : ?>
        <div class='mensaje-flash'><?= $mensaje ?></div>
    <?php endif; ?>

    <main class="reservas-list">
        <?php if ($reservas_count === 0) : ?>
            <p>No hay reservas hechas todavía.</p>
        <?php else : ?>
            <table class="tabla-reservas">
                <thead>
                    <tr>
                        <th>Destino</th>
                        <th>País</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservasHechas as $index => $idReserva) : ?>
                        <?php 
                            // Datos del viaje
                            $info = $viajes[$idReserva];
                        ?>
                        <tr>
                            <td><?= $info['destino'] ?></td>
                            <td><?= $info['pais'] ?></td>
                            <td><?= $info['duracion'] ?> días</td>
                            <td><?= number_format($info['precio'], 2, ",", ".") ?>€</td>
                            <td>
                                <a href="eliminar.php?index=<?= $index ?>" class="btn-delete">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>
