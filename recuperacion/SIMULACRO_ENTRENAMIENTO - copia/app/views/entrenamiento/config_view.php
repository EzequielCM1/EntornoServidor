<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configurar Entrenamiento</title>
</head>
<body>
    <h1>Asignar Nivel de Entrenamiento</h1>

    <!-- TODO 19: Mostrar detalles del animal seleccionado ($data['animal']) -->
    <p>Animal seleccionado: <strong><!-- Imprime el nombre aquí --></strong></p>

    <!-- TODO 20: Crear un formulario que haga POST a /entrenamiento/confirmar -->
    <form action="<?= BASE_URL ?>entrenamiento/confirmar" method="POST">
        <label for="nivel">Nivel:</label>
        <select name="nivel" id="nivel">
            <option value="Básico">Básico</option>
            <option value="Medio">Medio</option>
            <option value="Avanzado">Avanzado</option>
        </select>
        
        <button type="submit">Confirmar Entrenamiento</button>
    </form>

    <br>
    <a href="<?= BASE_URL ?>entrenamiento">Cancelar y volver</a>
</body>
</html>
