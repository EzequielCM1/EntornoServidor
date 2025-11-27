<?php
session_start();
require_once 'datos_musica.php';
$carrito = $_SESSION['carrito']??[];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Canciones</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>
<body>

<h1>Tu Carrito</h1>

<?php if (empty($_SESSION['carrito'])): ?>
    <p>No hay canciones en el carrito.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Título</th>
            <th>Artista</th>
        </tr>
        <?php foreach ($carrito as $cancion): ?>
        <tr>
            <td><?= $cancion['titulo']??'' ?></td>
            <td><?= $cancion['artista']??'' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br>
<a href="tienda.php">Volver a la Tienda</a>

</body>
</html>
