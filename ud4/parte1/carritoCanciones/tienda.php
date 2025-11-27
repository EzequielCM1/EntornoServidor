<?php
session_start();
require_once 'datos_musica.php';

// Inicializamos carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    if (isset($_POST['add'])) {
        $_SESSION['carrito'][$id] = CANCIONES[$id];
        $_SESSION['flash'] = "Canción añadida al carrito";
    }

    if (isset($_POST['remove'])) {
        unset($_SESSION['carrito'][$id]);
        $_SESSION['flash'] = "Canción eliminada del carrito";
    }


    header("Location: tienda.php");
    exit;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Canciones</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>
<body>

<h1>Tienda de Canciones</h1>

<?php if (isset($_SESSION['flash'])): ?>
    <p style="color: green;"><?= $_SESSION['flash'] ?></p>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>Título</th>
        <th>Artista</th>
        <th>Acciones</th>
    </tr>

    <?php foreach (CANCIONES as $cancion): ?>
    <tr>
        <td><?= $cancion['titulo'] ?></td>
        <td><?= $cancion['artista'] ?></td>
        <td>
            <?php if(!isset($_SESSION['carrito'][$cancion['id']])) :  ?>
            <form method="post" style="display:inline;">
                
                <input type="hidden" name="id" value="<?= $cancion['id'] ?>">
                
                <button type="submit" name="add">Añadir al Carrito</button>
                
            </form>
            <?php else :  ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $cancion['id'] ?>">
                <button type="submit" name="remove">Quitar del Carrito</button>
            </form>
            <?php endif ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<br>
<a href="carrito.php">Ir al Carrito</a>

</body>
</html>
