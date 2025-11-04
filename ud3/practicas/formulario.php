<?php
$errores = [];
$mensaje = "";
$nombre = $apellidos = $fecha = $genero = $curso = $email = $password = $passwordConf = $comentario = "";
$terminos = false ;
$preferencia = [];
$ruta = "usuarios.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['limpiar'])){
        $errores = [];
    $mensaje = "";
    $nombre = $apellidos = $fecha = $genero = $curso = $email = $password = $passwordConf = $comentario = "";
    $terminos = false ;
    $preferencia = [];

    header("Location: formulario.php");
    exit(); 
    }


    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $apellidos = htmlspecialchars(trim($_POST['apellidos'] ?? ''));
    $fecha = $_POST['fecha'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $curso = $_POST['curso']??'';
    $preferencia = $_POST['preferencia']??[];
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $passwordConf = $_POST['passwordConf']??'';
    $comentario = htmlspecialchars(trim($_POST['comentario'] ?? ''));
    $terminos = isset($_POST['terminos']);

    /* Validacion */
    if (empty($nombre)) {
        $errores["name"] = "El nombre es obligatorio";
    }

    if (empty($apellidos)) {
        $errores["apellidos"] = "Los apellidos son obligatorios";
    }

    if (empty($fecha)) {
        $errores["fecha"] = "La fecha de nacimiento es obligatorio";
    } else {
        $f = date_create($fecha);
        $actual = date_create();
        $edad = date_diff($f, $actual)->y; // esto srive para obtener los años
        if ($edad < 18) {
            $errores["fecha"] = "Debes tener 18 años como minimo";
        }
    }

    if (empty($genero)) {
        $errores["genero"] = "El género es obligatorio";
    }

    if (empty($email)) {
        $errores["email"] = "El email es obligatorio y debe tener formato válido";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores["email"] = "El formato del emial no es valido";
    }else{
        if(file_exists($ruta)){
            $fichero = fopen($ruta, "r");
            while(($fila = fgetcsv($fichero)) !== false){
                if($fila[5] == $email){
                    $errores["email"] = "Este correo ya existe";
                    break;
                }
            }
            fclose($fichero);
        }
    }

    if (empty($password)) {
        $errores["password"] = "La contraseña es obligatorio";
    }elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)){
        $errores["password"] = "La longitud debe ser hazta 8 caracteres , debe incluir una minuscula , una mayuscula y un numero ";
    }

    if(empty($passwordConf)){
        $errores["passwordConf"] = "Confirma la contraseña";
    }elseif ($password !== $passwordConf){
        $errores["passwordConf"] = "La contraseña no coincide";
    }

    if(empty($terminos)){
        $errores["terminos"] = "Debes aceptar los terminos y condiciones ";
    }

    if(empty($errores)){
        /* Si no hay errores abro el CSV y lo introduzco los datos  */
        $fichero = fopen($ruta, "a+");
        fputcsv($fichero, [$nombre, $apellidos, $fecha, $genero, $curso, $email, $password, $passwordConf, implode(", ", $preferencia), $comentario]);
        fclose($fichero);

        $mensaje = "Ya fuiste registrado correctamenrte";
        
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
        <h1>Formulario de Usuario</h1>
    </header>

    <main>
        
         <?php if ($mensaje) : ?>
            <div class="notice">
            <p class="success"><?= $mensaje ?></p>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="<?= $nombre?>"/>

                <?php if (!empty($errores['name'])) : ?>
                    <br /><span class="error"><?= $errores['name'] ?></span>
                <?php endif; ?>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" value="<?= $apellidos?>"/>

                <?php if (!empty($errores['apellidos'])) : ?>
                    <br /><span class="error"><?= $errores['apellidos'] ?></span>
                <?php endif; ?>

            <label for="fecha">Fecha de Nacimiento:</label>
            <input type="date" name="fecha" value="<?= $fecha?>"/>

                <?php if (!empty($errores['fecha'])) : ?>
                    <br /><span class="error"><?= $errores['fecha'] ?></span>
                <?php endif; ?>

            <label for="genero">Género:</label>
            <input type="radio" id="masculino" name="genero" value="masculino" <?= $genero == "masculino" ? "checked" : "" ?>>
            <label for="masculino">Masculino</label><br>
            <input type="radio" id="femenino" name="genero" value="femenino" <?= $genero == "femenino" ? "checked" : "" ?>>
            <label for="femenino">Femenino</label><br>
            <input type="radio" id="otro" name="genero" value="otro" <?= $genero == "otro" ? "checked" : "" ?>>
            <label for="otro">Otro</label>

                <?php if (!empty($errores['genero'])) : ?>
                    <br /><span class="error"><?= $errores['genero'] ?></span>
                <?php endif; ?>

                <hr>
            <label for="curso">Curso : </label>
            <select name="curso" id="curso">
                <option value="daw1" <?= $curso =='daw1'? "selected" : "" ?>>1DAW</option>
                <option value="daw2" <?= $curso =='daw2'? "selected" : "" ?>>2DAW</option>
                <option value="dam1" <?= $curso =='dam1'? "selected" : "" ?>>1DAM</option>
                <option value="dam2" <?= $curso =='dam2'? "selected" : "" ?>>2DAM</option>
            </select><br>

            <label for="preferencia">Preferencia : </label>
            <!-- Hago un bucle donde almaceno las opciones elegida para a la hora de enviar las opciones sigan marcadas  -->
            <?php 
            foreach(["deportes", "musica", "viajes"] as $opcion) {?>
            <label for=""> <input type="checkbox" name="preferencia[]" value="<?= $opcion ?>" <?= in_array($opcion,$preferencia)? "checked": "" ?> ><?= ucfirst($opcion)?></label>
            <?php }?>

                <hr>
            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" value="<?= $email?>" />

            <?php if (!empty($errores['email'])) : ?>
                    <br /><span class="error"><?= $errores['email'] ?></span>
                <?php endif; ?>

            <label for="password">Password : </label>
            <input type="password" name="password">
            <?php if (!empty($errores['password'])) : ?>
                    <br /><span class="error"><?= $errores['password'] ?></span>
                <?php endif; ?>
            <label for="passwordConfir">Confirmar Password</label>
            <input type="password" name="passwordConf">
                <?php if (!empty($errores['passwordConf'])) : ?>
                    <br /><span class="error"><?= $errores['passwordConf'] ?></span>
                <?php endif; ?>

            <label for="comentario">Comentarios :</label>
            <textarea name="comentario"><?= $comentario?></textarea>


            <input type="checkbox" name="terminos">
            <label for="terminos">Acepto terminos y condiciones </label>
                <?php if (!empty($errores['terminos'])) : ?>
                    <br /><span class="error"><?= $errores['terminos'] ?></span>
                <?php endif; ?>
            <br>

            <button type="submit">Enviar</button>
            <button type="submit" name="limpiar">Limpiar</button>
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>