<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Animal</title>
</head>
<body>
    <h1>Animales Sanos Disponibles</h1>

    <!-- TODO 17: Muestra aquí el mensaje flash si existe (usa $data['mensaje']) -->
    <?php if (isset($data['mensaje'])): ?>
        <p style="color: red;"><?= htmlspecialchars($data['mensaje']['mensaje'] ?? '', ENT_QUOTES) ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <!-- TODO 18: Haz un foreach sobre $data['animales'] para crear filas -->
            <!-- Aquí deberías tener un formulario por cada animal que envíe el 'id_animal' por POST a /entrenamiento/seleccionar -->
            <tr>
                <td colspan="4">No hay animales configurados todavía.</td>
            </tr>
        </tbody>
    </table>

    <a href="<?= BASE_URL ?>">Volver</a>
</body>
</html>
