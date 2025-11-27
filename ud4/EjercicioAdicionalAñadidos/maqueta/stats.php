<?php
require_once '../dataset.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $id = htmlspecialchars(trim($_GET['id'] ?? 0));

    if ($id === "" || !array_key_exists($id, $viajes)) {
        header("Location: index.php");
        exit();
    }

    $viaje = $viajes[$id];

    if (!isset($_SESSION['viajes_vistos'])) {
        $_SESSION['viajes_vistos'] = [];
    }

    if (!in_array($id, $_SESSION['viajes_vistos'])) {
        $_SESSION['viajes_vistos'][] = $id;
    }

    $precios = array_column($viajes, 'precio');
    $duraciones = array_column($viajes, 'duracion');

    $precioMedia = array_sum($precios) / count($precios);
    $duracionMedia = array_sum($duraciones) / count($duraciones);

    $precioMaximo = max($precios);
    $duracionMaxima = max($duraciones);

    $porcentajePrecio = round(($viaje['precio'] / $precioMaximo) * 100, 2);
    $porcentajeDuracion = round(($viaje['duracion'] / $duracionMaxima) * 100, 2);

    $warningPrecio = ($viaje['precio'] > $precioMedia) ? "warning" : "";
    $warningDuracion = ($viaje['duracion'] > $duracionMedia) ? "warning" : "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis del Viaje</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

    <div class="container">
        <a href="index.php" class="back-link">← Volver al listado</a>

        <section class="detail-card">
            <h1><?= $viaje['destino'] ?></h1>

            <div class="data-row">
                <span>📅 <?= $viaje['duracion'] ?> días</span>
                <span>🌍 <?= $viaje['pais'] ?></span>
                <span>⭐ <?= $viaje['valoracion'] ?>/5</span>
            </div>

            <div class="big-price">
                <?= number_format($viaje['precio'], 2, ",", ".") ?>€
            </div>

            <a href="reservar.php?id=<?= $id ?>" class="btn-reserve">Reservar este viaje</a>
        </section>

        <section class="detail-card stats-section">
            <h2>Comparativa con la Media del Catálogo</h2>

            <div class="stat-item">
                <div class="stat-label">
                    <span>Precio: <?= number_format($viaje['precio'], 2, ",", ".") ?>€</span>
                    <small>Media: <?= number_format($precioMedia, 2, ",", ".") ?>€</small>
                </div>
                <div class="bar-container">
                    <div class="bar-fill <?= $warningPrecio ?>" style="width: <?= $porcentajePrecio ?>%;"></div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-label">
                    <span>Duración: <?= $viaje['duracion'] ?> días</span>
                    <small>Media: <?= $duracionMedia ?> días</small>
                </div>
                <div class="bar-container">
                    <div class="bar-fill <?= $warningDuracion ?>" style="width: <?= $porcentajeDuracion ?>%;"></div>
                </div>
            </div>

        </section>
    </div>

</body>

</html>
