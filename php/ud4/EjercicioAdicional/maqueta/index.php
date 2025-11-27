<?php
session_start();
require_once '../dataset.php';

$mensaje = "";
if (isset($_SESSION['flash_message'])) {
    $mensaje = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

if (!isset($_SESSION['viajes_vistos'])) {
    $_SESSION['viajes_vistos'] = [];
}

if (!isset($_SESSION['reservas'])) {
    $_SESSION['reservas'] = [];
}

$reservas_count = count($_SESSION['reservas']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes - Catálogo</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <header>
        <h1>Destinos Disponibles</h1>
        <p>Selecciona un viaje para ver las estadísticas comparativas.</p>

        <div class="counter">
            Viajes reservados: <?= $reservas_count ?>
        </div>
    </header>

    <?php if (!empty($mensaje)) : ?>
        <div class='mensaje-flash'><?= $mensaje ?></div>
    <?php endif; ?>

    <main class="travel-grid">
        
        <?php foreach ($viajes as $id => $lugar) : ?>
            <?php
            $visto = in_array($id, $_SESSION['viajes_vistos']);
            ?>
            <article class="trip-card <?= $visto ? 'visited' : '' ?>">
                <div class="trip-img">
                    <img src="<?= $lugar['imagen'] ?>" alt="Foto del viaje">
                </div>
                <div class="trip-info">
                    <h2><?= $lugar['destino'] ?></h2>
                    <span class="meta"><?= $lugar['duracion'] ?> días | <?= $lugar['pais'] ?></span>
                    <p>Valoración: ⭐ <?= $lugar['valoracion'] ?>/5</p>
                </div>
                <div class="trip-action">
                    <span class="price"><?= number_format($lugar['precio'], 2, ",", ".") ?>€</span>
                    <a href="stats.php?id=<?= $id ?>" class="btn-select">Ver Análisis</a>
                </div>
            </article>
        <?php endforeach; ?>
    </main>
</body>

</html>
