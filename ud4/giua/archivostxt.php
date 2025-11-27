<?php
// ===============================
// PAGINA COMPLETA: FICHEROS PHP
// ===============================

$archivo = "datos.txt";
$mensaje = "";
$contenido = "";

// CREAR / SOBRESCRIBIR
if (isset($_POST['accion']) && $_POST['accion'] === 'sobrescribir') {
    $texto = trim($_POST['texto'] ?? "");
    file_put_contents($archivo, $texto . "\n");
    $mensaje = "✔ Archivo sobrescrito";
}

// AÑADIR
if (isset($_POST['accion']) && $_POST['accion'] === 'anadir') {
    $texto = trim($_POST['texto'] ?? "");
    if ($texto !== "") {
        file_put_contents($archivo, $texto . "\n", FILE_APPEND);
        $mensaje = "✔ Texto añadido";
    }
}

// LEER COMPLETO
if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
}

// LEER LINEA A LINEA
$lineas = [];
if (file_exists($archivo)) {
    $f = fopen($archivo, "r");
    while (!feof($f)) {
        $lineas[] = fgets($f);
    }
    fclose($f);
}

// LEER CARACTER A CARACTER
$caracteres = [];
if (file_exists($archivo)) {
    $f = fopen($archivo, "r");
    while (!feof($f)) {
        $caracteres[] = fgetc($f);
    }
    fclose($f);
}

// COPIAR ARCHIVO
if (isset($_POST['accion']) && $_POST['accion'] === 'copiar') {
    copy($archivo, "copia_" . $archivo);
    $mensaje = "✔ Archivo copiado";
}

// RENOMBRAR ARCHIVO
if (isset($_POST['accion']) && $_POST['accion'] === 'renombrar') {
    rename($archivo, "renombrado_" . $archivo);
    $archivo = "renombrado_" . $archivo;
    $mensaje = "✔ Archivo renombrado";
}

// BORRAR ARCHIVO
if (isset($_POST['accion']) && $_POST['accion'] === 'borrar') {
    if (file_exists($archivo)) {
        unlink($archivo);
        $mensaje = "✔ Archivo eliminado";
        $contenido = "";
        $lineas = [];
        $caracteres = [];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ficheros PHP Completo</title>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<style>
.container { max-width: 900px; margin: 2rem auto; }
pre { background:#eef; padding:10px; border-radius:6px; }
</style>
</head>
<body>
<div class="container">
<h1>Gestión Completa de Ficheros en PHP</h1>

<?php if ($mensaje): ?>
<p><strong><?= $mensaje ?></strong></p>
<?php endif; ?>

<h2>1. Escribir en archivo</h2>
<form method="POST">
    <input type="text" name="texto" placeholder="Escribe texto...">
    <button name="accion" value="anadir">Añadir (append)</button>
    <button name="accion" value="sobrescribir">Sobrescribir (write)</button>
</form>

<hr>

<h2>2. Leer archivo</h2>
<h3>Lectura completa</h3>
<pre><?= htmlspecialchars($contenido) ?></pre>

<h3>Línea a línea (fgets)</h3>
<pre><?php foreach ($lineas as $l) echo htmlspecialchars($l); ?></pre>

<h3>Carácter a carácter (fgetc)</h3>
<pre><?php foreach ($caracteres as $c) echo htmlspecialchars($c); ?></pre>

<hr>

<h2>3. Operaciones con archivos</h2>
<form method="POST">
    <button name="accion" value="copiar">Copiar archivo</button>
    <button name="accion" value="renombrar">Renombrar archivo</button>
    <button name="accion" value="borrar">Borrar archivo</button>
</form>

</div>
</body>
</html>
