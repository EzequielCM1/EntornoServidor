<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FantasyBoss - Mi Plantilla</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <div class="header-logo"><h1>⚽ FantasyBoss</h1></div>
            <nav class="main-nav">
                <a href="<?= BASE_URL ?>" class="nav-link">Jugadores</a>
                <a href="<?= BASE_URL ?>jornadas" class="nav-link">Jornadas</a>
                <a href="<?= BASE_URL ?>mi-plantilla" class="nav-link active">Mi Plantilla</a>
            </nav>
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name">
                        🎯 <?= htmlspecialchars($_SESSION['manager']['nombre']) ?>
                           <?= htmlspecialchars($_SESSION['manager']['apellidos']) ?>
                    </span>
                    <span class="user-role"><?= htmlspecialchars($_SESSION['manager']['liga']) ?> · <?= htmlspecialchars($_SESSION['manager']['puntos_totales']) ?> pts</span>
                </div>
                <a href="<?= BASE_URL ?>logout" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="content-container">

            <?php if (!empty($mensaje)): ?>
                <div class="flash-message flash-success">✅ <?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>

            <section class="page-header">
                <h2>📋 Mi Plantilla</h2>
                <p class="page-description">Gestiona los jugadores fichados en tus jornadas activas</p>
            </section>

            <section class="packages-section">

                <?php if (empty($plantilla)): ?>
                    <div class="empty-state" style="padding: 2rem;">
                        <p>📋 No tienes jugadores fichados.
                           <a href="<?= BASE_URL ?>">¡Ve al mercado a fichar!</a>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="packages-table">
                            <thead>
                                <tr>
                                    <th>Jugador</th>
                                    <th>Posición</th>
                                    <th>Club</th>
                                    <th>Jornada</th>
                                    <th>Precio</th>
                                    <th>Media</th>
                                    <th>Fecha fichaje</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($plantilla as $ficha): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($ficha['nombre_jugador']) ?></strong></td>
                                        <td><?= htmlspecialchars($ficha['posicion']) ?></td>
                                        <td><?= htmlspecialchars($ficha['club']) ?></td>
                                        <td>J<?= htmlspecialchars($ficha['numero_jornada']) ?></td>
                                        <td>💶 <?= htmlspecialchars($ficha['precio']) ?>M</td>
                                        <td>⭐ <?= htmlspecialchars($ficha['puntos_media']) ?></td>
                                        <td><?= htmlspecialchars(substr($ficha['fecha_fichaje'], 0, 10)) ?></td>
                                        <td>
                                            <span class="status-badge status-active">
                                                ✅ <?= htmlspecialchars($ficha['estado_fichaje']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form action="<?= BASE_URL ?>liberar/<?= $ficha['id'] ?>" method="POST">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    ❌ Liberar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </section>
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-container">
            <p>&copy; 2025 FantasyBoss — Sé el mejor manager</p>
        </div>
    </footer>

</body>
</html>
