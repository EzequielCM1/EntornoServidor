<?php
//inicializamos la sesión
session_start();

$contador = 1;
//si hemos mandado a eliminar la sesión
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['reset'])){
    unset($_SESSION['contador']); //destruimos la variable de sesión
}
//si existe un valor en la sesión lo recupero
if (isset($_SESSION['contador'])) {
    //recupero el valor de la sesión del contador, lo aumento en 1
    $contador = $_SESSION['contador'] + 1;
}
//actualizamos la sesión
$_SESSION['contador'] = $contador;

?>

<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Contador de visitas con sesiones</h2>
    </header>
    <main>
        <!-- Formulario para reiniciar el contador -->
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <button type="submit" name="recargar">Recargar Página</button>
            <button type="submit" name="reset">Reiniciar Contador</button>
        </form>
        <!-- // Mostrar el número de visitas -->
        <?php echo "<p class='notice'>Has visitado esta página $contador veces en esta sesión.</p>"; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>