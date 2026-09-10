<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FantasyBoss - Jugadores</title>
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
                <h2>⚽ Mercado de Jugadores</h2>
                <p class="page-description">Ficha jugadores para tus jornadas activas</p>
            </section>

            <!-- Filtro por posición -->
            <div class="filter-bar">
                <span class="filter-label">Filtrar por posición:</span>
                <a href="<?= BASE_URL ?>" class="filter-btn <?= !isset($_GET['posicion']) ? 'active' : '' ?>">Todos</a>
                <a href="<?= BASE_URL ?>?posicion=Portero"         class="filter-btn <?= ($_GET['posicion'] ?? '') === 'Portero'         ? 'active' : '' ?>">🧤 Portero</a>
                <a href="<?= BASE_URL ?>?posicion=Defensa"         class="filter-btn <?= ($_GET['posicion'] ?? '') === 'Defensa'         ? 'active' : '' ?>">🛡️ Defensa</a>
                <a href="<?= BASE_URL ?>?posicion=Centrocampista"  class="filter-btn <?= ($_GET['posicion'] ?? '') === 'Centrocampista'  ? 'active' : '' ?>">⚙️ Centrocampista</a>
                <a href="<?= BASE_URL ?>?posicion=Delantero"       class="filter-btn <?= ($_GET['posicion'] ?? '') === 'Delantero'       ? 'active' : '' ?>">🎯 Delantero</a>
            </div>

            <!-- Grid de jugadores -->
            <section class="jugadores-grid">

                <?php if (empty($jugadores)): ?>
                    <div class="empty-state">
                        <p>😴 No hay jugadores disponibles en este momento.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($jugadores as $jugador): ?>
                        <article class="jugador-card posicion-<?= strtolower(str_replace('á','a', $jugador['posicion'])) ?>">

                            <div class="jugador-image">
                                <img src="<?= htmlspecialchars($jugador['imagen_url']) ?>"
                                     alt="<?= htmlspecialchars($jugador['nombre']) ?>"
                                     onerror="this.src='<?= BASE_URL ?>img/jugador_default.png'">

                                <?php if ($jugador['estado'] === 'Disponible'): ?>
                                    <span class="jugador-status status-available">✅ Disponible</span>
                                <?php elseif ($jugador['estado'] === 'Fichado'): ?>
                                    <span class="jugador-status status-busy">📋 Fichado</span>
                                <?php elseif ($jugador['estado'] === 'Lesionado'): ?>
                                    <span class="jugador-status status-hurt">🩹 Lesionado</span>
                                <?php endif; ?>

                                <span class="posicion-badge pos-<?= strtolower(str_replace('á','a', $jugador['posicion'])) ?>">
                                    <?php
                                    $iconos = ['Portero'=>'🧤','Defensa'=>'🛡️','Centrocampista'=>'⚙️','Delantero'=>'🎯'];
                                    echo ($iconos[$jugador['posicion']] ?? '⚽') . ' ' . $jugador['posicion'];
                                    ?>
                                </span>
                            </div>

                            <div class="jugador-info">
                                <h3 class="jugador-nombre"><?= htmlspecialchars($jugador['nombre']) ?></h3>
                                <p class="jugador-club">🏟️ <?= htmlspecialchars($jugador['club']) ?> · 🌍 <?= htmlspecialchars($jugador['nacionalidad']) ?></p>

                                <div class="jugador-stats">
                                    <div class="stat-item">
                                        <span class="stat-icon">⭐</span>
                                        <div>
                                            <span class="stat-label">Media</span>
                                            <span class="stat-value"><?= $jugador['puntos_media'] ?></span>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-icon">💶</span>
                                        <div>
                                            <span class="stat-label">Precio</span>
                                            <span class="stat-value"><?= $jugador['precio'] ?>M</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Barra de media -->
                                <div class="media-bar">
                                    <div class="media-fill" style="width: <?= min(100, $jugador['puntos_media'] * 10) ?>%"></div>
                                </div>
                            </div>

                            <?php if ($jugador['estado'] === 'Disponible'): ?>
                                <div class="jugador-actions">
                                    <form action="<?= BASE_URL ?>fichar/<?= $jugador['id'] ?>" method="POST">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            📋 Fichar jugador
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </article>
                    <?php endforeach; ?>
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
