<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FantasyBoss - Jornadas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <div class="header-logo"><h1>⚽ FantasyBoss</h1></div>
            <nav class="main-nav">
                <a href="<?= BASE_URL ?>" class="nav-link">Jugadores</a>
                <a href="<?= BASE_URL ?>jornadas" class="nav-link active">Jornadas</a>
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

            <?php if (!empty($mensaje)): ?>
                <div class="flash-message flash-success">✅ <?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>

            <section class="page-header">
                <h2>📅 Jornadas Abiertas</h2>
                <p class="page-description">Selecciona una jornada para configurar tu plantilla</p>
            </section>

            <section class="jornadas-grid">

                <?php if (empty($jornadas)): ?>
                    <div class="empty-state">
                        <p>📅 No hay jornadas abiertas en este momento.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($jornadas as $jornada): ?>
                        <article class="jornada-card estado-<?= strtolower($jornada['estado']) ?>">

                            <div class="jornada-numero">J<?= $jornada['numero'] ?></div>

                            <div class="jornada-info">
                                <h3 class="jornada-nombre">Jornada <?= $jornada['numero'] ?></h3>
                                <p class="jornada-desc"><?= htmlspecialchars($jornada['descripcion']) ?></p>

                                <div class="jornada-stats">
                                    <div class="jornada-stat">
                                        <span>📅</span>
                                        <span><?= htmlspecialchars($jornada['fecha_inicio']) ?> → <?= htmlspecialchars($jornada['fecha_fin']) ?></span>
                                    </div>
                                    <div class="jornada-stat">
                                        <span>👥</span>
                                        <span><?= $jornada['slots_max'] ?> slots disponibles</span>
                                    </div>
                                    <div class="jornada-stat">
                                        <span>💶</span>
                                        <span><?= $jornada['presupuesto_max'] ?>M presupuesto</span>
                                    </div>
                                </div>

                                <?php if ($jornada['estado'] === 'Abierta'): ?>
                                    <span class="estado-badge estado-abierta">🟢 Abierta</span>
                                <?php elseif ($jornada['estado'] === 'Cerrada'): ?>
                                    <span class="estado-badge estado-cerrada">🔴 Cerrada</span>
                                <?php endif; ?>
                            </div>

                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

            </section>
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-container">
            <p>&copy; 2025 FantasyBoss</p>
        </div>
    </footer>

</body>
</html>
