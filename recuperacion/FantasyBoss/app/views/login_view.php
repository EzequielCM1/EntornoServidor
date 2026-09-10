<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FantasyBoss - Acceso</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-card">

            <header class="login-header">
                <div class="login-logo">⚽</div>
                <h1>FantasyBoss</h1>
                <p class="login-subtitle">Gestión de Fantasy Fútbol</p>
            </header>

            <main class="login-content">

                <?php if (!empty($mensaje)): ?>
                    <div class="flash-message flash-success">
                        ✅ <?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mensajeError)): ?>
                    <div class="flash-message flash-error">
                        ❌ <?= htmlspecialchars($mensajeError) ?>
                    </div>
                <?php endif; ?>

                <section class="scanner-section">
                    <h2>Acceso de Manager</h2>
                    <p class="login-hint">Formato: <strong>MAN-001-1234</strong></p>

                    <form action="login" method="POST" class="scanner-form">
                        <div class="form-group">
                            <label for="credencial">🎯 Código de manager:</label>
                            <input
                                type="text"
                                name="credencial"
                                id="credencial"
                                class="form-control"
                                placeholder="Ej: MAN-001-1234"
                                autocomplete="off"
                                autofocus>
                            <?php if (isset($errores['credencial'])): ?>
                                <span class="error-message">⚠️ <?= $errores['credencial'] ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            ⚽ Entrar al campo
                        </button>
                    </form>
                </section>

            </main>

            <footer class="login-footer">
                <p>&copy; 2025 FantasyBoss — Sé el mejor manager</p>
            </footer>

        </div>
    </div>
</body>
</html>
