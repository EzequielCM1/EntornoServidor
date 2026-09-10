<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monroy Delivery - Acceso</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="login-body">
    <div class="login-container">
        <div class="login-card">
            <header class="login-header">
                <h1>🚚 Monroy Delivery</h1>
                <p class="login-subtitle">Sistema de Logística y Optimización</p>
            </header>

            <main class="login-content">
                <!-- Mensaje Flash -->
                <div class="flash-message flash-error">
                    Mensaje de error autentificación
                </div>

                <section class="scanner-section">
                    <div class="scanner-img">
                        <img src="./img/logo_monroy.png">
                    </div>
                    <h2>Formulario de acceso</h2>
                    <form action="#" method="" class="scanner-form">
                        <div class="form-group">
                            <label for="credencial">Código de Acceso:</label>
                            <input
                                type="text"
                                name="credencial"
                                id="credencial"
                                class="form-control"
                                placeholder="Ej: EMP01-1234"
                                autocomplete="off"
                                autofocus>
                            <span class="error-message">Mensaje de error de validación</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            🔓 Acceder al Sistema
                        </button>
                    </form>
                </section>
            </main>

            <footer class="login-footer">
                <p>&copy; 2025 Monroy Delivery - by P.Lluyot</p>
            </footer>
        </div>
    </div>
</body>

</html>