<?php
// ================================================
// GUIA BÁSICA DE COOKIES EN PHP
// (El código PHP real está explicado en el HTML)
// ================================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía de Cookies en PHP</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>
<body>

<header>
    <h1>🍪 Guía Básica de Cookies en PHP</h1>
    <p>Todo lo esencial sobre cómo crear, leer, modificar y eliminar cookies.</p>
</header>

<main>

<section>
    <h2>1. ¿Qué es una cookie?</h2>
    <p>
        Una cookie es un pequeño dato que el servidor guarda en el navegador del usuario. 
        Sirve para recordar información entre visitas, como el nombre del usuario, preferencias, etc.
    </p>
</section>

<section>
    <h2>2. Crear una cookie</h2>
<pre><code>
// Crear una cookie llamada "usuario" que dura 7 días
setcookie(
    "usuario",                      // nombre de la cookie
    "Ezequiel",                     // valor
    time() + (7 * 24 * 60 * 60),    // duración: 7 días
    "/"                             // disponible en todo el sitio
);
</code></pre>
</section>

<section>
    <h2>3. Leer una cookie</h2>
<pre><code>
if (isset($_COOKIE['usuario'])) {
    echo "Hola de nuevo, " . $_COOKIE['usuario'];
} else {
    echo "No hay cookie creada.";
}
</code></pre>
</section>

<section>
    <h2>4. Modificar una cookie</h2>
<pre><code>
// Modificar una cookie = volver a crearla
setcookie("usuario", "NuevoNombre", time() + 3600, "/");
</code></pre>
</section>

<section>
    <h2>5. Eliminar una cookie</h2>
<pre><code>
// Para eliminar una cookie se le pone una fecha pasada
setcookie("usuario", "", time() - 3600, "/");
</code></pre>
</section>

<section>
    <h2>6. Cookies seguras (HTTPS recomendado)</h2>
<pre><code>
setcookie(
    "token",
    "XYZ123",
    time() + 3600,
    "/",
    "",
    true,   // secure: solo HTTPS
    true    // httponly: protege frente a JavaScript
);
</code></pre>
</section>

</main>

<footer>
    <p>Guía creada como ejemplo educativo para aprender PHP.</p>
</footer>

</body>
</html>
