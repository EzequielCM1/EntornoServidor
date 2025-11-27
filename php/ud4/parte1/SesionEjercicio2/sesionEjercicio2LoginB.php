<?php
    session_start();
    $usuario = "";
    $password = "";
    $errores = [];
    $mensaje = "";
    $usuarios = [
        "pepe" => "1234",
        "ezequiel" => "1234"
    ];

    if(isset($_SESSION['usuario'])){
        header("Location: sesionEjercicio2Redirigido.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = htmlspecialchars(trim($_POST['name']??''));
        $password = trim($_POST['password']??'');

        if($usuario === ""){
            $errores['usuario'] = "El usuario esta vacio";
        }
        if($password === ""){
            $errores['password'] = "La contraseña esta vacia";
        }

        if(empty($errores)){
            if(isset($usuarios[$usuario]) && $usuarios[$usuario]==$password){
                $mensaje = "Usuario autentificado";
                
                // guardamos la sesion en la cookie
                $_SESSION['usuario']=$usuario;
                header("Location: sesionEjercicio2Redirigido.php");
                exit();
            }else{
                $mensaje = "Parametros incorrectos";
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Login Básico</h1>
    </header>
    <style>
        .error {
            color: red;
            font-size: 0.9rem;
        }
    </style>

    <main>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <label for="name">Usuario:</label>
            <input type="text" id="name" name="name" value="<?= $usuario?>" />
            <br>
            <?php if (!empty($errores['usuario'])): ?>
                    <span class="error"><?= $errores['usuario'] ?></span>
                <?php endif; ?>
            <label for="contrasenia">Contraseña : </label>
            <input type="password" name="password" id="password" value="<?= $password?>"><br>
            <?php if (!empty($errores['password'])): ?>
                    <span class="error"><?= $errores['password'] ?></span>
                <?php endif; ?>
            <br>
            <button type="submit" name="submit">Iniciar sesion</button>
        </form>
        <?php if (!empty($mensaje)) : ?>
           <p class='notice'><?= htmlspecialchars($mensaje); ?></p>
       <?php endif; ?>

    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>