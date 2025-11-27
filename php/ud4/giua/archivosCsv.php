<?php
// =============================================
// PAGINA COMPLETA: FICHEROS PHP + CSV + UPLOAD
// =============================================

$archivo = "datos.txt";
$csv = "datos.csv";
$mensaje = "";
$contenido = "";
$contenidoCSV = [];

// ==========================
// 1. ESCRITURA TXT
// ==========================
if (isset($_POST['accion']) && $_POST['accion'] === 'sobrescribir') {
    $texto = trim($_POST['texto'] ?? "");
    file_put_contents($archivo, $texto . "
");
    $mensaje = "✔ Archivo sobrescrito";
}

if (isset($_POST['accion']) && $_POST['accion'] === 'anadir') {
    $texto = trim($_POST['texto'] ?? "");
    if ($texto !== "") {
        file_put_contents($archivo, $texto . "
", FILE_APPEND);
        $mensaje = "✔ Texto añadido";
    }
}

// ==========================
// 2. LECTURA TXT
// ==========================
if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
}

// ==========================
// 3. CSV: Añadir fila
// ==========================
if (isset($_POST['accion']) && $_POST['accion'] === 'add_csv') {
    $c1 = trim($_POST['c1']);
    $c2 = trim($_POST['c2']);
    $c3 = trim($_POST['c3']);
    if ($c1 !== "" || $c2 !== "" || $c3 !== "") {
        $fila = "$c1;$c2;$c3" . "
";
        file_put_contents($csv, $fila, FILE_APPEND);
        $mensaje = "✔ Fila añadida al CSV";
    }
}

// ==========================
// 4. CSV: Leer
// ==========================
if (file_exists($csv)) {
    $f = fopen($csv, "r");
    while (($linea = fgetcsv($f, 0, ";")) !== false) {
        $contenidoCSV[] = $linea;
    }
    fclose($f);
}

// ==========================
// 5. SUBIDA DE ARCHIVOS
// ==========================
if (isset($_POST['accion']) && $_POST['accion'] === 'subir') {
    if ($_FILES['fichero']['error'] === 0) {
        $nombre = basename($_FILES['fichero']['name']);
        move_uploaded_file($_FILES['fichero']['tmp_name'], "uploads/" . $nombre);
        $mensaje = "✔ Archivo subido correctamente";
    } else {
        $mensaje = "❌ Error al subir archivo";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión Completa de Ficheros en PHP</title>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<style>
.container { max-width: 900px; margin: 2rem auto; }
pre { background:#eef; padding:10px; border-radius:6px; }
table { width:100%; }
</style>
</head>
<body>
<div class="container">
<h1>Gestión Completa de Ficheros en PHP</h1>

<?php if ($mensaje): ?><p><strong><?= $mensaje ?></strong></p><?php endif; ?>

<!-- ================= TEXTOS ================= -->
<h2>1. Escribir en archivo TXT</h2>
<form method="POST">
    <input type="text" name="texto" placeholder="Escribe texto...">
    <button name="accion" value="anadir">Añadir (append)</button>
    <button name="accion" value="sobrescribir">Sobrescribir (write)</button>
</form>

<h3>Contenido completo</h3>
<pre><?= htmlspecialchars($contenido) ?></pre>

<hr>

<!-- ================= CSV ================= -->
<h2>2. Gestionar archivo CSV</h2>
<form method="POST">
    <input type="text" name="c1" placeholder="Campo 1">
    <input type="text" name="c2" placeholder="Campo 2">
    <input type="text" name="c3" placeholder="Campo 3">
    <button name="accion" value="add_csv">Añadir fila al CSV</button>
</form>

<h3>Contenido CSV</h3>
<table>
<tr><th>C1</th><th>C2</th><th>C3</th></tr>
<?php foreach ($contenidoCSV as $fila): ?>
<tr>
    <td><?= htmlspecialchars($fila[0] ?? "") ?></td>
    <td><?= htmlspecialchars($fila[1] ?? "") ?></td>
    <td><?= htmlspecialchars($fila[2] ?? "") ?></td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<!-- ================= UPLOAD ================= -->
<h2>3. Subida de archivos</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="fichero">
    <button name="accion" value="subir">Subir archivo</button>
</form>

</div>
</body>
</html>
