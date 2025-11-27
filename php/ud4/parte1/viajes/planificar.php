<?php
session_start();
if(!isset($_SESSION['viaje'])){
    header("Location: index.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['reset'])){
    header("Location: index.php");
    exit();
}

$destino = $_SESSION['viaje']['destino']??'';
$dias = $_SESSION['viaje']['dias']??'';
$itinerario = $_SESSION['viaje']['itinerario']??[];
$actividad = "";
$errores = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $actividad = htmlspecialchars(trim($_POST['act']??''));
    $diaSeleccionado = htmlspecialchars($_POST['dia']??'');

    if(empty($actividad)){
        $errores['actividad'] = "debes introducir la actividad ";
    }

    if(empty($errores)){
        array_push($_SESSION['viaje']['itinerario'][$diaSeleccionado], $actividad);
        header("Location: planificar.php");
        exit();
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
    </style>
</head>

<body>
    <header>
        <h1>Planificar el viaje</h1>
    </header>

    <main>
        <h3>Planificando el viaje a :<?= $destino ?></h3>
        <form action="" method="post">
            <label for="name">Nueva Actividad:</label>
            <input type="text" id="act" name="act" /><br>
            <?php if (!empty($errores['actividad'])): ?>
                    <span class="error"><?= $errores['actividad'] ?></span>
                <?php endif; ?>
            <br>
            <select name="dia" id="dia">
                <?php for($i = 1; $i <= $_SESSION['viaje']['dias'] ; $i++): ?>
                    <option value="<?= 'dia'.$i ?>">Día <?= $i ?></option>
                <?php endfor; ?>
            </select>
                    <br>
            <button type="submit">Guardar</button>
            <button type="submit" name="reset" >Formatear</button>
        </form>
        <?php for($i =1 ; $i <= $dias; $i++): ?>
        <details>
            <summary>Dia <?= $i ?></summary>
            <?php if(empty($itinerario['dia'.$i])){ ?>
                <p>No hay actividad</p>
            <?php }else{ ?>
                <?php foreach($itinerario['dia'.$i] as $valor):?>
                    <p><?=  $valor ?></p>
            <?php endforeach; }?>
        </details>
        <?php endfor; ?>
        
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>