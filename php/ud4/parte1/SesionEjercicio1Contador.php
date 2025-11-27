<?php
    session_start();
    $contador = 0;
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['reset'])){
        unset($_SESSION['contador']);
    }

    if(isset($_SESSION['contador'])){
        $contador = $_SESSION['contador'] +1;
        $_SESSION['contador'] = $contador;
    }
    $_SESSION['contador'] = $contador;
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
        <h1>Contador de sesiones</h1>
    </header>

    <main>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        
            <button type="submit" name="submit">Recargar</button>
            <button type="submit" name="reset">Reiniciar</button>
        </form>
        <div class="notice"><?= "Has visitado esta pagina : $contador" ;?></div>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>