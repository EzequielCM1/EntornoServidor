<?php
$mensaje = "";
$extencionPermitida = ["jpg", "png", "jpeg"];
$subido = false;
$destino = "";

// ✅ Definimos la función antes de usarla
function guardarArchivo($subido, $destino)
{
    if ($subido === true) {
        if (file_exists($destino)) {
            return "✅ Archivo guardado correctamente en '$destino'";
        } else {
            return "⚠️ No se encontró el archivo para guardar.";
        }
    } else {
        return "❌ No se puede guardar: la subida no fue correcta.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_FILES['fichero_imagen'])) {
        $archivo = $_FILES['fichero_imagen'];
        $nombre = basename($archivo["name"]);
        $destino = "upload/" . $nombre;
        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        if ($archivo['error'] == UPLOAD_ERR_OK) {

            // Validación de extensión
            if (!in_array($extension, $extencionPermitida)) {
                $mensaje .= "❌ Extensión no permitida. ";
            }
            // Validación de tamaño
            elseif ($archivo['size'] > 8000000) {
                $mensaje .= "❌ Sobrepasa los límites de tamaño. ";
            }
            // Mover archivo al destino
            elseif (move_uploaded_file($archivo['tmp_name'], $destino)) {
                $mensaje .= "✅ Archivo subido correctamente. ";
                $subido = true;
            } else {
                $mensaje .= "❌ Error al mover el archivo. ";
            }
        } else {
            $mensaje .= "❌ Error con la subida. ";
        }
    }

    // Si se pulsa el botón de guardar
    if (isset($_POST['accion']) && $_POST['accion'] === 'guardar') {
        $mensaje .= guardarArchivo($subido, $destino);
    }
}
?>
<!DOCTYPE html>
<html lang='es'>
<head>
   <meta charset='UTF-8'>
   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <title>Zequi</title>
   <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>
<body>
   <header>
       <h1>Ejercicio 10 - Subida y guardado</h1>
   </header>
   <main>

   <form action="" method="POST" enctype="multipart/form-data">
        <label>Sube un fichero jpg, jpeg o png (máximo 8MB):</label>
        <input type="file" name="fichero_imagen" id="fichero_imagen">

        <p>
            <button type="submit" name="accion" value="subir">Subir</button>
            <button type="submit" name="accion" value="guardar">Guardar</button>
        </p>
   </form>

   <?php if (!empty($mensaje)) : ?>
       <p class='notice'><?= $mensaje; ?></p>
   <?php endif; ?>

   <?php if ($subido && file_exists($destino)) : ?>
       <h3>Vista previa:</h3>
       <img src="<?= htmlspecialchars($destino); ?>" alt="Imagen subida" style="max-width:300px;">
   <?php endif; ?>

   </main>
   <footer>
       <p>Zequi</p>
   </footer>
</body>
</html>
