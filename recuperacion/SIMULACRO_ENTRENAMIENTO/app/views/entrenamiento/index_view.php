<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Selección de Entrenamiento</title>
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Header re-utilizado del listado_view -->
    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <nav class="nav-links">
                <a href="" class="nav-link">Panel de Control</a>
                <a href="entrenamiento" class="nav-link activo">Módulo de Entrenamiento</a>
                <a href="#" class="nav-link">Enlace2</a>
            </nav>

            <div class="header-user">
                <!-- Botón para cerrar sesión -->
                <a href="logout" class="btn-salir">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="wrapper">

        <!-- FLASH MESSAGE -->
        <?php if (isset($mensaje) && $mensaje) : ?>
            <div class="flash <?= $mensaje['clase'] ?>">
                <span class="flash-icono"><?= $mensaje['icono'] ?></span>
                <?= $mensaje['mensaje'] ?>
            </div>
        <?php endif; ?>

        <section class="seccion-head">
            <div class="num-pill"><?= count($animales ?? []) ?> animales</div>
            <h2>Seleccionar Animal para Entrenamiento</h2>
        </section>

        <p class="hero-sub" style="color: var(--tinta-media); margin-bottom: 40px; max-width: 600px;">
            Elige a uno de nuestros compañeros que se encuentre <strong style="color: var(--verde-vida)">Sano</strong> para comenzar su programa de adiestramiento personalizado.
        </p>

        <div class="grid-mascotas">
            <?php if (empty($animales)) : ?>
                <div class="empty-state">
                    <div class="empty-icon">🍃</div>
                    <h3 class="empty-title">No hay animales sanos disponibles</h3>
                    <p class="empty-text">Actualmente todos los animales están en entrenamiento o requieren otros cuidados.</p>
                </div>
            <?php else : ?>
                <?php foreach ($animales as $animal) : ?>
                    <article class="card">
                        <div class="card-img-box">
                            <img src="img/<?= $animal['especie'] ?>.jpg" alt="<?= $animal['nombre'] ?>" class="card-img" onerror="this.src='https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=500&auto=format&fit=crop'">
                            <span class="badge badge-especie"><?= ucfirst($animal['especie']) ?></span>
                        </div>
                        <div class="card-body">
                            <div class="card-header-row">
                                <h3 class="card-nombre"><?= $animal['nombre'] ?></h3>
                                <div class="card-datos">
                                    <span class="dato-pill">
                                        <span class="dato-icono">⚖️</span>
                                        <span class="dato-valor"><?= $animal['peso'] ?> kg</span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="stats">
                                <div class="stat">
                                    <div class="stat-row">
                                        <span class="stat-label">📚 Adiestramiento</span>
                                        <span class="stat-val"><?= $animal['nivel_adiestramiento'] ?>/10</span>
                                    </div>
                                    <div class="track">
                                        <div class="fill fill-x" style="width: <?= $animal['nivel_adiestramiento'] * 10 ?>%"></div>
                                    </div>
                                </div>
                            </div>

                            <form action="entrenamiento/seleccionar" method="POST">
                                <input type="hidden" name="id_animal" value="<?= $animal['id'] ?>">
                                <button type="submit" class="btn-accion btn-accion1">
                                    <span class="btn-emoji">🎓</span>
                                    <div>
                                        <span>Seleccionar para entrenar</span>
                                        <span class="sub">Empezar programa</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Cuidando su futuro.</p>
    </footer>

</body>

</html>
