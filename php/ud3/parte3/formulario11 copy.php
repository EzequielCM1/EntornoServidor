<?php
$mensaje = "";
$extencionPermitida = "txt";
$destino = "";
$nombre = $_POST['nombre'] ?? '';
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar el nombre
    if (empty($nombre)) {
        $errores["nombre"] = "El nombre debe contener texto";
    } elseif (strlen($nombre) > 30 || strlen($nombre) < 3) {
        $errores["nombre"] = "El nombre debe tener entre 3 y 30 caracteres";
    }

    // Validar archivo
    if (isset($_FILES['fichero'])) {
        $archivo = $_FILES['fichero'];
        $extencion = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if ($archivo['error'] == UPLOAD_ERR_OK) {
            if ($extencion !== $extencionPermitida) {
                $errores["extencion"] = "La extensión debe ser txt";
            } elseif ($archivo['size'] > 100) {
                $errores["size"] = "El archivo no debe superar 100 bytes";
            } else {
                $destino = "upload/" . basename($archivo['name']);
                if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                    $mensaje = "Archivo subido correctamente.";
                } else {
                    $errores["subida"] = "Error al subir el archivo.";
                }
            }
        }
    } else {
        $errores["existe"] = "Debes subir un archivo txt";
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

    <style>
        .error {
            color: red;
            font-size: 15px;
        }
    </style>

</head>

<body>
    <header>
        <h1>Ejercicio 11 - Subida con nombre de fichero</h1>
    </header>
    <main>
        <form action="" method="POST" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre del archivo</label>
                <input type="text" name="nombre" id="nombre"><br>
              
            </p>

            <label>Sube un fichero txt (máximo 100byte):</label>
            <input type="file" name="fichero" id="fichero"><br>
           
            <p>
                <button type="submit" name="accion" value="subir">Subir</button>
            </p>
        </form>



    </main>
    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>