<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Ficha de <?= $animal['nombre'] ?></title>
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- HEADER -->
    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <nav class="nav-links">
                <a href="" class="nav-link">Panel de Control</a>
                <a href="#" class="nav-link activo">Ficha del Animal</a>
            </nav>

            <div class="header-user">
                <span class="user-text">Bienvenido, <strong><?= $usuario ?></strong></span>
                <a href="logout" class="btn-salir">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="wrapper">
        <section class="seccion-head">
            <a href="" style="text-decoration: none; color: var(--tierra); font-weight: 600;">← Volver al listado</a>
            <h2>Ficha Detallada: <?= $animal['nombre'] ?></h2>
        </section>

        <!-- DETALLE DEL ANIMAL -->
        <article class="hero" style="grid-template-columns: 0.8fr 1.2fr; min-height: 500px;">
            <div class="hero-foto" style="background-image: url('img/<?= $animal['imagen'] ?>');">
                <span class="hero-tag">ID: #<?= $animal['id'] ?></span>
            </div>

            <div class="hero-panel" style="justify-content: flex-start; gap: 30px;">
                <div class="card-header-row">
                    <h1 class="hero-h1" style="color: var(--tinta); font-size: 4rem;"><?= $animal['nombre'] ?></h1>
                    <span class="badge badge-especie" style="position: static;"><?= $animal['especie'] ?></span>
                </div>

                <div class="card-datos">
                    <span class="dato-pill" style="font-size: 1.1rem; padding: 10px 20px;">
                        <span class="dato-icono">🎂</span>
                        <span class="dato-valor"><?= $animal['edad'] ?> años</span>
                    </span>
                    <span class="dato-pill" style="font-size: 1.1rem; padding: 10px 20px;">
                        <span class="dato-icono">⚖️</span>
                        <span class="dato-valor"><?= $animal['peso'] ?> kg</span>
                    </span>
                    <span class="dato-pill" style="font-size: 1.1rem; padding: 10px 20px;">
                        <span class="dato-icono">🧬</span>
                        <span class="dato-valor"><?= $animal['raza'] ?></span>
                    </span>
                </div>

                <div class="stats" style="margin-top: 20px;">
                    <div class="stat">
                        <div class="stat-row">
                            <span class="stat-label" style="font-size: 1.1rem;">📚 Nivel de Adiestramiento</span>
                            <span class="stat-val" style="font-size: 1.2rem;"><?= $animal['nivel_adiestramiento'] ?> / 10</span>
                        </div>
                        <div class="track" style="height: 12px;">
                            <div class="fill fill-x" style="width:<?= $animal['nivel_adiestramiento'] * 10 ?>%"></div>
                        </div>
                    </div>
                    <div class="stat" style="margin-top: 15px;">
                        <div class="stat-row">
                            <span class="stat-label" style="font-size: 1.1rem;">📋 Puntos de Expediente</span>
                            <span class="stat-val" style="font-size: 1.2rem;"><?= $animal['puntos_expediente'] ?> / 100</span>
                        </div>
                        <div class="track" style="height: 12px;">
                            <div class="fill fill-y" style="width:<?= $animal['puntos_expediente'] ?>%"></div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: auto; padding-top: 30px; border-top: 1px solid var(--tierra-medio);">
                    <p class="acciones-label">Acciones de Práctica</p>
                    <form method="POST" action="entrenar">
                        <input type="hidden" name="id_animal" value="<?= $animal['id'] ?>">
                        <button type="submit" class="btn-accion btn-accion1">
                            <span class="btn-emoji">⚡</span>
                            <span>Sesión de Entrenamiento Intensivo<br><small>Sube estadísticas y registra log</small></span>
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Práctica de Examen Segunda Parte.</p>
    </footer>

</body>

</html>
