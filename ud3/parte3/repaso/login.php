<?php
$mensaje = "";
$ruta = "loginValidos.txt";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars(trim($_POST['name']?? ''));
    $contrasenia = htmlspecialchars(trim($_POST['contra']?? ''));

    if (empty($usuario)) {
        $errores["usuarioV"] = "Debes introducir el usuario";
    }
    if(empty($contrasenia)){
        $errores["contrasenia"] = "Debes poner la contraseña";
    }

    if(empty($errores)){
        $usuarios = [];
        $encontrado = false;

        if(file_exists($ruta)){
            $fichero= fopen($ruta, "r");
            while (($linea = fgets($fichero)) !== false) {
                $linea = trim($linea);

                if ($linea === "") continue; // Saltar líneas vacías
                $datos = explode("," ,$linea);

                if(count($datos) === 3){
                     if ($datos[0] === $usuario && $datos[1] === $contrasenia) {
                        $encontrado = true;
                        $datos[2] = (int)$datos[2] + 1;
                        $mensaje = "Bienvenido <b>$usuario</b> 
                                    Has iniciado sesión <b>{$datos[2]}</b> veces.";
                    }
                    $usuarios[] = $datos;
                }
                
            }fclose($fichero);
        }
        if ($encontrado) {
            $fichero = fopen($ruta, "w");
            foreach ($usuarios as $u) {
                fwrite($fichero, implode(",", $u) . PHP_EOL);
            }
            fclose($fichero);
        } elseif (empty($mensaje)) {
            $mensaje = "<span class='error'>Usuario o contraseña incorrectos.</span>";
        }

    }

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subida de archivo con palabras</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>
        .error {
            color: red;
            font-size: 0.9rem;
        }

        .success {
            color: green;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Login</h1>
    </header>

    <main>
        <form action="" method="POST">
            <p>
                <label for="name">Usuario :</label>
                <input type="text" id="name" name="name">
                <?php if (!empty($errores['usuarioV'])) : ?>
                    <br /><span class="error"><?= $errores['usuarioV'] ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="contra">Contraseña :</label>
                <input type="text" id="contra" name="contra">
                <?php if (!empty($errores['contrasenia'])) : ?>
                    <br /><span class="error"><?= $errores['contrasenia'] ?></span>
                <?php endif; ?>
            </p>

            <input type="submit" value="Login" name="login">
        </form>

        <?php if ($mensaje) : ?>
            <p class="success"><?= $mensaje ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>