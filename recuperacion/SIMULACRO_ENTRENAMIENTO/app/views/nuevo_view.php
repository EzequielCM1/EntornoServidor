<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Nuevo Rescate</title>
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
                <a href="nuevo" class="nav-link activo">Nuevo Rescate</a>
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
            <h2>Registrar Nuevo Rescate</h2>
        </section>

        <!-- FORMULARIO DE ALTA -->
        <div class="card" style="max-width: 700px; margin: 0 auto; padding: 40px;">
            <form action="nuevo" method="POST">
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nombre del Animal *</label>
                    <input type="text" name="nombre" value="<?= $datos['nombre'] ?? '' ?>" class="input-c" style="width: 100%;" placeholder="Ej: Toby">
                    <?php if (isset($errores['nombre'])): ?>
                        <p style="color: #e74c3c; font-size: 0.9rem; margin-top: 5px;"><?= $errores['nombre'] ?></p>
                    <?php endif; ?>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Especie *</label>
                        <select name="especie" class="input-c" style="width: 100%; height: 45px;">
                            <option value="">Selecciona...</option>
                            <option value="canino" <?= (isset($datos['especie']) && $datos['especie'] == 'canino') ? 'selected' : '' ?>>Canino</option>
                            <option value="felino" <?= (isset($datos['especie']) && $datos['especie'] == 'felino') ? 'selected' : '' ?>>Felino</option>
                            <option value="otro" <?= (isset($datos['especie']) && $datos['especie'] == 'otro') ? 'selected' : '' ?>>Otro</option>
                        </select>
                        <?php if (isset($errores['especie'])): ?>
                            <p style="color: #e74c3c; font-size: 0.9rem; margin-top: 5px;"><?= $errores['especie'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Raza / Variedad</label>
                        <input type="text" name="raza" value="<?= $datos['raza'] ?? '' ?>" class="input-c" style="width: 100%;" placeholder="Ej: Husky">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Edad (años)</label>
                        <input type="number" name="edad" value="<?= $datos['edad'] ?? '0' ?>" class="input-c" style="width: 100%;">
                        <?php if (isset($errores['edad'])): ?>
                            <p style="color: #e74c3c; font-size: 0.9rem; margin-top: 5px;"><?= $errores['edad'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" value="<?= $datos['peso'] ?? '0.0' ?>" class="input-c" style="width: 100%;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nivel Adiestramiento (1-10)</label>
                        <input type="number" name="nivel_adiestramiento" min="1" max="10" value="<?= $datos['nivel_adiestramiento'] ?? '1' ?>" class="input-c" style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Puntos Expediente (0-100)</label>
                        <input type="number" name="puntos_expediente" min="0" max="100" value="<?= $datos['puntos_expediente'] ?? '50' ?>" class="input-c" style="width: 100%;">
                    </div>
                </div>

                <div class="form-group" style="text-align: center;">
                    <button type="submit" class="btn-c btn-m" style="padding: 15px 40px; font-size: 1.1rem; width: auto;">Guardar Mascota 🐾</button>
                </div>

                <?php if (isset($errores['general'])): ?>
                    <p style="color: #e74c3c; font-weight: 600; text-align: center; margin-top: 20px;"><?= $errores['general'] ?></p>
                <?php endif; ?>

            </form>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> — Practicando CRUD estilo Monroy Delivery.</p>
    </footer>

</body>

</html>
