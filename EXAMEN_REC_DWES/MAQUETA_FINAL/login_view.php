<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaAnimal — Acceder</title>
    <!-- <base href=""> -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="login-body">

    <div class="login-wrap">

        <!-- Panel izquierdo: imagen -->
        <div class="login-foto">
            <div class="login-foto-texto">
                <p class="login-foto-titulo">Un refugio<br>con <em>alma.</em></p>
                <p class="login-foto-sub">Accede para gestionar<br>a tus rescatados.</p>
            </div>
        </div>

        <!-- Panel derecho: formulario -->
        <div class="login-form-panel">

            <div class="login-logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <div>
                <h1 class="login-titulo">
                    Bienvenido de vuelta
                    <span>Introduce tus credenciales para continuar.</span>
                </h1>
            </div>
            <!--
                NOTAS PARA EL EXAMEN:
                - Validar que usuario y password no estén vacíos
                - Mostrar error bajo cada campo si está vacío
                - Buscar usuario en BBDD y verificar password con password_verify
                - Si error, mostrar mensaje general sobre el formulario
                - Mantener valor del campo usuario (sticky form)
            -->
            <form method="POST" action="login" class="login-campos" novalidate="">

                <!-- USUARIO -->
                <div class="campo-grupo">
                    <label for="usuario" class="campo-label">Usuario</label>
                    <input type="text" id="usuario" name="usuario" class="campo-input campo-input--error" value="" placeholder="tu_usuario" autocomplete="username" aria-describedby="error-usuario">
                    <span class="campo-error" id="error-usuario" role="alert">
                        Usuario es requerido </span>
                </div>

                <!-- CONTRASEÑA -->
                <div class="campo-grupo">
                    <label for="password" class="campo-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="campo-input campo-input--error" placeholder="••••••••" autocomplete="current-password" aria-describedby="error-password">
                    <span class="campo-error" id="error-password" role="alert">
                        Contraseña es requerida </span>
                </div>

                <!-- FLASH MESSAGE (credenciales incorrectas, sesión expirada, etc.) -->
                <div class="flash error" role="alert" aria-live="polite">
                    <span class="flash-icono">
                        ✖ </span>
                    Credeciales incorrectas. Inténtelo de nuevo.
                </div>
                <button type="submit" class="btn-login">Entrar al refugio →</button>
            </form>
        </div>
    </div>


</body>

</html>