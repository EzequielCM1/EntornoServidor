<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Configurar Entrenamiento</title>
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .config-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin: 40px 0;
            align-items: start;
        }
        .config-form-box {
            background: var(--pergamino);
            padding: 40px;
            border-radius: var(--radio-org);
            box-shadow: var(--sombra);
            border: 1px solid rgba(196, 112, 58, 0.1);
        }
        select.campo-input {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1.5px solid var(--crema-oscuro);
            background: white;
            font-family: var(--sans);
            font-size: 1rem;
            color: var(--tinta);
            margin-bottom: 25px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>
            <div class="header-user">
                <a href="entrenamiento" class="nav-link">← Cancelar y Volver</a>
            </div>
        </div>
    </header>

    <main class="wrapper">

        <section class="seccion-head">
            <h2>Configuración del Programa</h2>
        </section>

        <div class="config-container">
            <!-- Detalles del Animal -->
            <div class="animal-preview">
                <article class="card" style="animation: none; transform: none; box-shadow: none; border: 1.5px solid var(--tierra-medio);">
                    <div class="card-img-box">
                        <img src="img/<?= $animal['especie'] ?>.jpg" alt="<?= $animal['nombre'] ?>" class="card-img" onerror="this.src='https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=500&auto=format&fit=crop'">
                        <span class="badge badge-especie"><?= ucfirst($animal['especie']) ?></span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-nombre"><?= $animal['nombre'] ?></h3>
                        <p class="hero-sub" style="color: var(--tinta-media); font-size: 0.9rem; margin-top: 10px;">
                            Estás a punto de asignar un plan de entrenamiento para este animal. Define el nivel de intensidad a continuación.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Formulario de Configuración -->
            <div class="config-form-box">
                <h3 class="acciones-label">Detalles del Entrenamiento</h3>
                
                <form action="entrenamiento/confirmar" method="POST">
                    <div class="campo-grupo">
                        <label for="nivel" class="campo-label">Nivel de Intensidad</label>
                        <select name="nivel" id="nivel" class="campo-input">
                            <option value="Básico">🟢 Nivel Básico (Socialización)</option>
                            <option value="Medio">🟠 Nivel Medio (Obediencia)</option>
                            <option value="Avanzado">🔴 Nivel Avanzado (Especializado)</option>
                        </select>
                    </div>

                    <p style="font-size: 0.85rem; color: var(--tierra); margin-bottom: 30px; font-style: italic;">
                        * Al confirmar, el estado del animal pasará automáticamente a "En Entrenamiento".
                    </p>

                    <button type="submit" class="btn-accion btn-accion1">
                        <span class="btn-emoji">✅</span>
                        <div>
                            <span>Confirmar Programa</span>
                            <span class="sub">Registrar en el sistema</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Preparando el mañana.</p>
    </footer>

</body>

</html>
