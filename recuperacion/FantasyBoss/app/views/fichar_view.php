<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FantasyBoss - Fichar Jugador</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <div class="header-logo"><h1>⚽ FantasyBoss</h1></div>
            <nav class="main-nav">
                <a href="<?= BASE_URL ?>" class="nav-link active">Jugadores</a>
                <a href="<?= BASE_URL ?>jornadas" class="nav-link">Jornadas</a>
                <a href="<?= BASE_URL ?>mi-plantilla" class="nav-link">Mi Plantilla</a>
            </nav>
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name">🎯 <?= htmlspecialchars($_SESSION['manager']['nombre']) ?></span>
                    <span class="user-role"><?= htmlspecialchars($_SESSION['manager']['liga']) ?></span>
                </div>
                <a href="<?= BASE_URL ?>logout" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="content-container">

            <!-- Info del jugador seleccionado -->
            <?php if (!empty($jugador)): ?>
            <section class="selected-jugador-info">
                <div class="jugador-summary">
                    <img src="<?= htmlspecialchars($jugador[0]['imagen_url']) ?>"
                         alt="<?= htmlspecialchars($jugador[0]['nombre']) ?>"
                         onerror="this.src='<?= BASE_URL ?>img/jugador_default.png'">
                    <div class="summary-details">
                        <h2>⚽ <?= htmlspecialchars($jugador[0]['nombre']) ?></h2>
                        <p>
                            <?= htmlspecialchars($jugador[0]['posicion']) ?> ·
                            <?= htmlspecialchars($jugador[0]['club']) ?> ·
                            Media: <?= $jugador[0]['puntos_media'] ?> ·
                            Precio: <?= $jugador[0]['precio'] ?>M
                        </p>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <section class="page-header">
                <h2>📅 Selecciona una jornada</h2>
                <p class="page-description">Elige la jornada en la que quieres incluir a este jugador</p>
            </section>

            <section class="jornadas-grid">
                <?php if (empty($jornadas)): ?>
                    <div class="empty-state">
                        <p>📅 No hay jornadas abiertas con slots disponibles.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($jornadas as $jornada): ?>
                        <article class="jornada-card estado-abierta">
                            <div class="jornada-numero">J<?= $jornada['numero'] ?></div>
                            <div class="jornada-info">
                                <h3 class="jornada-nombre">Jornada <?= $jornada['numero'] ?></h3>
                                <p class="jornada-desc"><?= htmlspecialchars($jornada['descripcion']) ?></p>
                                <div class="jornada-stats">
                                    <div class="jornada-stat"><span>👥</span><span><?= $jornada['slots_max'] ?> slots libres</span></div>
                                    <div class="jornada-stat"><span>💶</span><span><?= $jornada['presupuesto_max'] ?>M presupuesto</span></div>
                                </div>
                                <form action="<?= BASE_URL ?>confirmar-fichaje" method="POST" style="margin-top: 1rem;">
                                    <input type="hidden" name="id_jornada" value="<?= $jornada['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        ✅ Fichar para esta jornada
                                    </button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-container"><p>&copy; 2025 FantasyBoss</p></div>
    </footer>

</body>
</html>
