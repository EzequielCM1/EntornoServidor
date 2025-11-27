<?php
session_start();

// Guardas nombre, puntos=0, turno=1 en index.php y llegas aquí por GET.

// Utilidades
function personajeAleatorio()
{
    $personajes = [
        'nombre' => [
            'Juan',
            'Manuela',
            'Pedro',
            'Lucía',
            'Carlos',
            'Ana',
            'Luis',
            'Marta',
            'Jorge',
            'Sofía'
        ],
        'profesion' => [
            'herrero del barrio de abajo',
            'albañil de las murallas',
            'molinero del río',
            'armero itinerante',
            'mensajero de la villa',
            'médico de camino',
            'muletero de la encomienda',
            'carpintero de obra',
            'hortelano del arrabal',
            'vendedora de telas y cordeles'
        ],
        'motivo' => [
            'trae clavos y herraduras para la guarnición, “las pidió el capataz ayer tarde”',
            'viene a revisar una grieta en la torre norte antes de que vaya a más',
            'trae harina para la cocina, “si no entra hoy, mañana no hay pan”',
            'ofrece afilar lanzas y revisar correas “por buen precio y mejor mano”',
            'entrega un mensaje sellado para el mayordomo del castillo',
            'busca pasar para atender a un soldado con fiebre en la enfermería',
            'entra con dos acémilas cargadas de heno para las caballerizas',
            'trae tablas cortadas a medida para el puente del patio',
            'pide acceso al pozo “porque en el huerto no queda ni gota”',
            'quiere montar un puesto en el patio durante el mercado de mañana'
        ]
    ];
    return [
        'nombre' => $personajes['nombre'][array_rand($personajes['nombre'])],
        'profesion' => $personajes['profesion'][array_rand($personajes['profesion'])],
        'motivo' => $personajes['motivo'][array_rand($personajes['motivo'])],
        'impostor' => rand(0, 1)
    ];
}
function evaluar($accion, $impostor)
{
    $acierto = ($accion === 'pasar' && $impostor == 0) || ($accion === 'rechazar' && $impostor == 1);
    if ($acierto) return ['correcto', 10, '¡Correcto! Has ganado 10 puntos.', 'El personaje era ' . ($impostor ? 'un impostor' : 'legítimo') . '.'];
    return ['incorrecto', -5, '¡Incorrecto! Has perdido 5 puntos.', 'El personaje era ' . ($impostor ? 'un impostor' : 'legítimo') . '.'];
}

// Guardia
if (!isset($_SESSION['nombre'])) {
    header('Location: index.php', true, 303);
    exit;
}

// Iniciales
$_SESSION['puntos'] = $_SESSION['puntos'] ?? 0;
$_SESSION['aciertos'] = $_SESSION['aciertos'] ?? 0;
$_SESSION['fallos'] = $_SESSION['fallos'] ?? 0;
$_SESSION['turno'] = $_SESSION['turno'] ?? 1;

// POST: procesar decisión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'fin') {
        header('Location: fin.php', true, 303);
        exit;
    }
    // Necesitamos personaje actual para evaluar
    $personaje = $_SESSION['personaje_actual'] ?? null;
    if (!$personaje) {
        // Si por algún motivo no existe, generamos uno y PRG
        $_SESSION['personaje_actual'] = personajeAleatorio();
        header('Location: juego.php', true, 303);
        exit;
    }

    // Evaluación
    [$estado, $delta, $msg, $impostor] = evaluar($accion, $personaje['impostor']);
    $_SESSION['puntos'] += $delta;
    if ($estado === 'correcto') $_SESSION['aciertos']++;
    else $_SESSION['fallos']++;

    // Guardar mensaje para mostrar en el siguiente GET
    $_SESSION['flash_msg'] = $msg;
    $_SESSION['flash_impostor'] = $impostor;
    $_SESSION['flash_estado'] = $estado;

    // Incrementar turno después de evaluar
    $_SESSION['turno']++;

    // Si se ha llegado al turno 6 significa que se han jugado 5 turnos ya
    /*if ($_SESSION['turno'] > 5) {
        // Limpiar personaje para no mostrar más
        unset($_SESSION['personaje_actual']);
        header('Location: fin.php', true, 303);
        exit;
    }*/

    // Preparar siguiente GET sin reenvío POST
    // Limpiar personaje para forzar nuevo personaje en GET
    unset($_SESSION['personaje_actual']);
    header('Location: juego.php', true, 303); // PRG
    exit;
}

// GET: mostrar pantalla
$turno = $_SESSION['turno'];
$puntos = $_SESSION['puntos'];

// Mensaje flash si existe
$mensaje = $_SESSION['flash_msg'] ?? null;
$mensaje_impostor = $_SESSION['flash_impostor'] ?? null;
$estado = $_SESSION['flash_estado'] ?? null;
// Tras leerlos, los eliminamos para no repetir
unset($_SESSION['flash_msg'], $_SESSION['flash_estado'], $_SESSION['flash_impostor']);

// Si no hay personaje y aún quedan turnos reales, generarlo
if (!isset($_SESSION['personaje_actual']) && $turno <= 5) {
    $_SESSION['personaje_actual'] = personajeAleatorio();
}
$personaje = $_SESSION['personaje_actual'] ?? null;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Turno <?= htmlspecialchars($turno) ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h1>Puertas del castillo</h1>
    <!-- Tabla de estadísticas del juego -->
    <table class="stats-table">
        <tr>
            <th>TURNO</th>
            <th>Puntos</th>
            <th>Aciertos</th>
            <th>Fallos</th>

        </tr>
        <tr>
            <td><?= htmlspecialchars(min($turno, 5)) ?> / 5</td>
            <td><?= htmlspecialchars($puntos) ?></td>
            <td><?= htmlspecialchars($_SESSION['aciertos']) ?></td>
            <td><?= htmlspecialchars($_SESSION['fallos']) ?></td>
        </tr>
    </table>
    <h2>Personaje</h2>
    <?php if ($personaje && $turno <= 5): ?>
        <table class="datos-table">
            <tr>
                <th>Nombre</th>
                <td><?= htmlspecialchars($personaje['nombre']) ?></td>
            </tr>
            <tr>
                <th>Profesión</th>
                <td><?= htmlspecialchars($personaje['profesion']) ?></td>
            </tr>
            <tr>
                <th>Motivo</th>
                <td><?= htmlspecialchars($personaje['motivo']) ?></td>
            </tr>
        </table>
    <?php endif; ?>



    <form method="post" action="juego.php">
        <?php if ($turno <= 5): ?>
            <button name="accion" value="pasar">Dejar pasar</button>
            <button name="accion" value="rechazar">Rechazar entrada</button>
        <?php else: ?>
            <button name="accion" value="fin">Fin</button>
        <?php endif; ?>
    </form>
    <?php if ($mensaje): ?>
        <p class="<?= $estado === 'correcto' ? 'ok' : 'error' ?>"><?= htmlspecialchars($mensaje_impostor) ?></p>
        <p class="<?= $estado === 'correcto' ? 'ok' : 'error' ?>"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</body>

</html>