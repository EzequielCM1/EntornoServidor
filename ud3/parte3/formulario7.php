<?php
$mensaje = "";
$tareas = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarea = $_POST['tarea']?? '';
    $array_serializado = $_POST['tarea_set']?? '';
    $tareas = unserialize($array_serializado);
    

    // validamos la tarea 
    if(empty($tarea)){
        $mensaje = "la tarea debe contener texto";
    }elseif(in_array($tarea, $tareas)){
        $mensaje = "la tarea ya existe";
    }  
    else{ // añadimos al array
        $tareas [] = $tarea;
        // desializar el array 
        
    }



    
}

$array_texto = serialize($tareas);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <title>Document</title>
</head>

<body>
    <head>
    <h1>Registro de tareas</h1>
</head>
    <form method="POST">

        <label for="tarea">tarea</label>
        <input type="text" name="tarea" id="tarea" placeholder="tarea">    
        <input type="text" name="tarea_set" id="tarea_set" value="<?php echo htmlspecialchars(($array_texto)??'' ); ?>">

        <button type="submit" name="agregar" value="agregar">Agregar Tarea</button>
        <button type="submit" name="borrar" value="borrar">Borrar</button>
    </form>

    <ol>
        <?php foreach ($tareas as $tarea): ?>
            <li><?= htmlspecialchars($tarea) ?></li>
        <?php endforeach; ?>
    </ol>
    <?php if(!empty($mensaje)) : ?>
        <p class="notice"><?$mensaje?></p>
    <?php endif; ?>
</body>

</html>