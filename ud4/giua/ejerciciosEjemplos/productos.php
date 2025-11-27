<?php
session_start();

/* ==========================================================
   CONFIGURACIÓN INICIAL
========================================================== */

// Array por defecto
$productosIniciales = [
    ["id" => 1, "nombre" => "Teclado",   "precio" => 25.50],
    ["id" => 2, "nombre" => "Ratón",     "precio" => 12.00],
    ["id" => 3, "nombre" => "Monitor",   "precio" => 159.99]
];

// Crear sesión si no existe
if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = $productosIniciales;
}

// Crear cookie de contador
if (!isset($_COOKIE["contador_add"])) {
    setcookie("contador_add", 0, time() + 3600);
}


/* ==========================================================
   FUNCIONES
========================================================== */

// Generar nuevo ID autoincremental
function nuevoID($productos)
{
    if (empty($productos)) return 1;
    $ids = array_column($productos, "id");
    return max($ids) + 1;
}

// Añadir producto
function agregarProducto(&$productos, $nombre, $precio)
{
    $id = nuevoID($productos);

    // Crear cadena con implode (solo ejemplo)
    $cadena = implode(";", [$id, $nombre, $precio]);

    // Convertir cadena en array de producto EHEMPLO PARA ENSEÑAR
    list($id, $nombre, $precio) = explode(";", $cadena);

    /*oTRA FORMA ES ESTA 
    $linea = implode(";", [$id, $nombre, $precio]) . PHP_EOL;
    file_put_contents("productos.csv", $linea, FILE_APPEND);
*/
    $productos[] = [
        "id" => intval($id),
        "nombre" => $nombre,
        "precio" => floatval($precio)
    ];
}

// Eliminar producto por ID
function eliminarProducto(&$productos, $id)
{
    foreach ($productos as $i => $p) {
        if ($p["id"] == $id) {
            unset($productos[$i]);
            $_SESSION["productos"] = array_values($productos);
            return true;
        }
    }
    return false;
}


/* ==========================================================
   PROCESAR FORMULARIO
========================================================== */

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Eliminar
    if (isset($_POST["eliminar"])) {
        $idEliminar = intval($_POST["eliminar"]);
        eliminarProducto($_SESSION["productos"], $idEliminar);
    }

    // Añadir
    if (isset($_POST["add"])) {
        $nombre = trim($_POST["nombre"] ?? "");
        $precio = trim($_POST["precio"] ?? "");

        // Validaciones
        if ($nombre === "") {
            $errores[] = "El nombre no puede estar vacío.";
        }

        if (!filter_var($precio, FILTER_VALIDATE_FLOAT)) {
            $errores[] = "El precio debe ser un número válido.";
        }

        if (empty($errores)) {
            agregarProducto($_SESSION["productos"], $nombre, $precio);

            // Aumentar cookie
            setcookie("contador_add", $_COOKIE["contador_add"] + 1, time() + 3600);

            $mensaje = "Producto añadido correctamente.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>

    <h2>Gestión de Productos</h2>

    <!-- Mensajes -->
    <?php if (!empty($mensaje)): ?>
        <p class="ok"><?= $mensaje ?></p>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $e): ?>
            <p class="error">⚠ <?= $e ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Contador cookie -->
    <p><strong>Productos añadidos en esta sesión:</strong> <?= $_COOKIE["contador_add"] ?? 0 ?></p>

    <!-- Formulario -->
    <form action="" method="POST">
        <h3>Añadir producto</h3>

        <label>Nombre:</label><br>
        <input type="text" name="nombre">

        <label>Precio:</label><br>
        <input type="text" name="precio">

        <button type="submit" name="add">Guardar</button>
    </form>

    <!-- Tabla de productos -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio (€)</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($_SESSION["productos"] as $p): ?>
            <tr>
                <td><?= $p["id"] ?></td>
                <td><?= $p["nombre"] ?></td>
                <td><?= number_format($p["precio"], 2) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="eliminar" value="<?= $p["id"] ?>">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>