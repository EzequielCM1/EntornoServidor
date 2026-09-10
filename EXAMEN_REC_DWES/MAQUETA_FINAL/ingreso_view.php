<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Adopción — SalvaVidas</title>
    <!-- <base href=""> -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Ejemplos estáticos para previsualizar: -->
    <!-- FLASH MESSAGE (credenciales incorrectas, sesión expirada, etc.) -->
    <div class="flash ok"><span class="flash-icono">✔</span> Ejemplo de mensaje flash de éxito</div>
    <!-- <div class="flash error"><span class="flash-icono">✖</span> No se pudo completar la acción.</div>  -->
    <!-- <div class="flash aviso"><span class="flash-icono">⚡</span> Thor necesita atención urgente.</div>  -->

    <!-- HEADER -->
    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <nav class="nav-links">
                <a href="listado_view.php" class="nav-link">Panel de Control</a>
                <!-- ### enlaces NUEVOS ### -->
                <a href="adopcion_view.php" class="nav-link">Centro de Adopción</a>
                <a href="ingreso_view.php" class="nav-link activo">Nuevo Ingreso</a>
                <!-- ### fin enlaces NUEVOS ### -->
            </nav>

            <div class="header-user">
                <!-- Aquí mostrar nombre del usuario desde la sesión -->
                <span class="user-text">Bienvenido, <strong>USUARIO</strong></span>
                <!-- Botón para cerrar sesión -->
                <a href="logout" class="btn-salir">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="wrapper">

        <!-- BANDA HERO -->
        <div class="ingreso-banda">
            <h1 class="adopcion-banda-titulo">Nuevo <em>ingreso.</em></h1>
            <p class="adopcion-banda-sub">Registra un nuevo animal en el refugio. Se generará un diagnóstico inicial automático.</p>
        </div>

        <!-- FORMULARIO -->
        <div class="ingreso-form-wrap">
            <div class="ingreso-form-panel">

                <!--
                    EJERCICIO 4 - ADMISION Y VALIDACIÓN
                    - Ruta: POST /ingreso/validar
                    - Validar en PHP (NO HTML5):
                      * Nombre: obligatorio, mínimo 3 letras
                      * Especie: obligatorio (canino/felino/otro)
                      * Raza: obligatoria
                      * Edad: obligatoria, numérico, entero, no negativo
                      * Peso: obligatorio, numérico, positivo (decimales OK)
                    - Si error: guardar en sesión y redirigir (mostrar errores + valores previos)
                    - Si todo OK: Guardar en BBDD: 
                        - energía=50, higiene=50, imagen según especie
                        - actualizar en_refugio=1
                -->
                <!-- formulario que apunta a la ruta ingreso/validar -->
                <form method="POST" action="ingreso/validar" class="ingreso-form" novalidate>

                    <!-- FILA: Nombre + Especie -->
                    <div class="ingreso-fila">

                        <div class="campo-grupo">
                            <label for="nombre" class="campo-label">Nombre</label><!--nombre del animal-->
                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                class="campo-input campo-input--error"
                                value=""
                                placeholder="Ej: Luna"
                                autocomplete="off"><!-- se añade la clase campo-input--error cuando hay un error de validación ->meter esto en la clase php echo (isset($errores['nombre']) ? 'campo-input--error' : '')  ?> -->
                            <!-- ejemplo de error de validación -->
                            <span class="campo-error" id="error-nombre" role="alert">Ejemplo de error de validación: El nombre es obligatorio</span>
                        </div>

                        <div class="campo-grupo">
                            <label for="especie" class="campo-label">Especie</label><!--especie del animal-->
                            <select id="especie" name="especie" class="campo-input"><!-- se añade la clase campo-input--error cuando hay un error de validación ->meter esto en la clase php echo (isset($errores['especie']) ? 'campo-input--error' : '')  ?> -->
                                <option value="">— Selecciona —</option>
                                <option value="canino">🐶 Canino</option>
                                <option value="felino">🐱 Felino</option>
                                <option value="otro">Otro</option>
                            </select>
                            <!-- Ejemplo error: <span class="campo-error" id="error-especie" role="alert">La especie es obligatoria</span> -->
                        </div>

                    </div>

                    <!-- RAZA -->
                    <div class="campo-grupo">
                        <label for="raza" class="campo-label">Raza</label><!--raza del animal-->
                        <input
                            type="text"
                            id="raza"
                            name="raza"
                            class="campo-input"
                            placeholder="Ej: Labrador, Siamés, Mestizo..."
                            autocomplete="off"><!-- se añade la clase campo-input--error cuando hay un error de validación ->meter esto en la clase php echo (isset($errores['raza']) ? 'campo-input--error' : '')  ?> -->
                        <!-- Ejemplo error: <span class="campo-error" id="error-raza" role="alert"">La raza es obligatoria</span> -->
                    </div>

                    <!-- FILA: Edad + Peso -->
                    <div class="ingreso-fila">

                        <div class="campo-grupo">
                            <label for="edad" class="campo-label">Edad (años)</label><!--edad del animal-->
                            <input
                                type="number"
                                id="edad"
                                name="edad"
                                class="campo-input"
                                placeholder="Ej: 3"
                                min="0"
                                max="100"
                                step="1"><!-- se añade la clase campo-input--error cuando hay un error de validación ->meter esto en la clase php echo (isset($errores['raza']) ? 'campo-input--error' : '')  ?> -->
                            <!-- Ejemplo error: <span class="campo-error" id="error-edad" role="alert">La edad debe ser un número entero positivo</span> -->
                        </div>

                        <div class="campo-grupo">
                            <label for="peso" class="campo-label">Peso (kg)</label><!--peso del animal-->
                            <input
                                type="number"
                                id="peso"
                                name="peso"
                                class="campo-input"
                                placeholder="Ej: 4.20"
                                min="0"
                                max="100"
                                step="0.01"><!-- se añade la clase campo-input--error cuando hay un error de validación ->meter esto en la clase php echo (isset($errores['peso']) ? 'campo-input--error' : '')  ?> -->
                            <!-- Ejemplo error: <span class="campo-error">El peso debe ser un número positivo</span> -->
                        </div>

                    </div>

                    <!-- BOTONES -->
                    <div class="ingreso-btns">
                        <a href="listado_view.php" class="btn-reset">Cancelar</a><!--apunta al listado de animales-->
                        <button type="submit" class="btn-login">🐾 Registrar animal</button><!-- hace submit al formulario-->
                    </div>

                </form>
            </div>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Hecho con ❤️ para los que no tienen voz.</p>
    </footer>

</body>

</html>