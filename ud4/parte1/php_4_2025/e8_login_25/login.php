<?php
    //inciamos la sesión
    session_start();

    //autentificación de sesión
    if (isset($_SESSION['usuario'])){
        //si no existe la variable de sesión del usuario
        header("Location: principal.php");
        exit();
    }

    //Inicializar variables
    $usuario='';
    $password='';
    $errores =[];
    $mensaje='';

    //array con usuarios y contraseñas (no es la forma habitual. Lo normal es almaccenarlos encriptados y en una base de datos)
    $basedatos =[
        "pepe" => '1234',
        "juan" => '0000',
        "ana" => '1111'
    ];


    //recuperamos los datos del formulario.
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $usuario= trim($_POST['usuario'])??'';
        $password = trim($_POST['password'])??'';
        //validamos que los campos estén rellenos
        if ($usuario===''){
            $errores['usuario']="Usuario es requerido";
        }
        if ($password===''){
            $errores['password']="Password es requerido";
        }
        //si no hay errores, comprobamos el usuario y el password
        if(empty($errores)){
            //si esl usuario y passwd es correcto
            if (isset($basedatos[$usuario]) && $basedatos[$usuario]==$password){
                //$mensaje = "Usuario autentificado";
                //guardar en sesion el usuario
                $_SESSION['usuario']=$usuario;
                header("Location: principal.php");
                exit();
            }else{
                $mensaje = "Usuario y password incorrectos";  
            }
        }
    }
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Formulario de login</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <style>
        small{
            color:red;
            font-size: small;
            display:block;
            margin-bottom:10px;
        }
    </style>
</head>

<body>
    <header>
        <h2>Iniciar sesión</h2>
    </header>
    <main>
        <form action="login.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?=htmlspecialchars($usuario);?>" >
                <?php if (isset($errores['usuario'])) echo "<small>{$errores['usuario']}</small>";?>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" value="<?=htmlspecialchars($password);?>">
                <?php if (isset($errores['password'])) echo "<small>{$errores['password']}</small>";?>

            </p>
            <input type="submit" name="enviar" value="Iniciar Sesión">
        </form>
        <?php if ($mensaje!='') echo "<p class='notice'>$mensaje</p>"; ?>
        <?php //if (isset($errores['login'])) echo "<p class='notice'>{$errores['login']}</p>";?>

    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>