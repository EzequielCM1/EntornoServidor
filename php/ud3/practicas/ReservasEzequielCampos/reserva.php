<?php
$mensaje = [];

$reservas = [
    ["nombre" => "Luis", "personas" => 4, "exterior" => true, "hora" => "21:00"],
    ["nombre" => "Marta", "personas" => 3, "exterior" => false, "hora" => "20:30"],
    ["nombre" => "Carlos", "personas" => 5, "exterior" => true, "hora" => "21:00"],
    ["nombre" => "Elena", "personas" => 6, "exterior" => false, "hora" => "20:00"],
    ["nombre" => "Sofía", "personas" => 1, "exterior" => true, "hora" => "20:15"]
];
$accion = $_GET['accion'] ?? '';
$nombre = $_GET['nombre'] ?? '';
$personas = $_GET['personas'] ?? 0;
$exterior = ($_GET['exterior'] ?? 'false') === 'true';
$hora = $_GET['hora'] ?? '';

function realizarReserva($nombreCliente, $numPersonas, $exterior = false, $horaReserva = '20:00')
{
    $reservasOcupadas = 0;
    global $mensaje, $reservas;
    if ($numPersonas < 1 || $numPersonas > 6) {
        $mensaje["error"] = "El limite de persona es de 6";
        return;
    }

    foreach ($reservas as $reserva) {
        if (strtolower($reserva['nombre']) == strtolower($nombreCliente)) {
            $mensaje["error"] = "Ya existe una reserva a este nombre : $nombreCliente";
            return;
        }
    }

    $mesasNecessarias = ($numPersonas <= 4) ? 1 : 2;
    foreach ($reservas as $reserva) {
        $reservasOcupadas += ($reserva['personas'] <= 4) ? 1 : 2;
    }
    $reservasOcupadas += $mesasNecessarias;
    if ($reservasOcupadas >= 10) {
        $mensaje["error"] = "No hay mesas disponibles";
        return;
    }

    if (empty(strtotime($horaReserva))) {
        $horaReserva = "20:00";
    } elseif ((strtotime($horaReserva) < strtotime("20:00")) || (strtotime($horaReserva) > strtotime("22:00"))) {
        $mensaje["error"] = "La hora debe estar comprendida entre las 20:00 y las 22:00";
        return;
    }



    $reservas[] = [
        "nombre" => $nombreCliente,
        "personas" => $numPersonas,
        "exterior" => $exterior,
        "hora" => $horaReserva,
    ];
    $mensaje["valido"] = "Reserva realizada correctamente a nombre de $nombreCliente para $numPersonas";
}

function mostrarReservas()
{
    global $mensaje, $reservas;
    $mesasOcupadas = 0;
    if (empty($reservas)) {
        $mensaje["error"] = "No existe ninguna reserva";
        return;
    }
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Personas</th><th>Exterior</th><th>Hora</th></tr>";
    foreach ($reservas as $reserva) {
        echo "<tr>";
        echo "<td>" . $reserva['nombre'] . "</td>";
        echo "<td>" . $reserva['personas'] . "</td>";
        echo "<td>" . ($reserva['exterior'] ? "si" : "no") . "</td>";
        echo "<td>" . $reserva['hora'] . "</td>";
        echo "</tr>";
        $mesasOcupadas += ($reserva['personas'] <= 4) ? 1 : 2;
    }
    echo "</table>";
    echo '<p class="mesas">Mesas ocupadas : <strong>' . $mesasOcupadas . '</strong></p>';
}

function cancelarReserva($nombreCliente)
{
    global $mensaje, $reservas;
    if (empty($reservas)) {
        $mensaje["error"] = "No existe reservas";
    }
    foreach ($reservas as $i => $reserva) {
        if (strtolower($nombreCliente) == strtolower($reserva['nombre'])) {
            unset($reservas[$i]);
            $reservas = array_values($reservas); // para no dejar huecos vacios entre cada reserva 
            $mensaje["valido"] = "Reserva cancelada , a nombre de $nombreCliente";
            return;
        }
    }
    $mensaje["error"] = "No se ha encontrado la reserva de $nombreCliente";
}

switch ($accion) {
    case "reservar":
        if ($nombre && $personas) {
            realizarReserva($nombre, $personas, $exterior, $hora, $reservas);
        } else {
            $mensaje["error"] = "Falta poner algunos parametros , se debe indicar el nombre y las personas";
        }
        break;
    case "cancelar":
        if ($nombre) {
            cancelarReserva($nombre);
        } else {
            $mensaje["error"] = "Falta poner el nombre de la reserva";
        }
        break;
    case "mostrar":
        $mensaje["valido"] = "Mostrando las reservas";
        break;
    default:
        $mensaje["error"] = "Indica la accion , reservar o cancelar";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reservar Mesa</title>
    <link rel="stylesheet" href="./reserva.css">
</head>

<body>
    <header>
        <h1>Reservar Mesa</h1>
    </header>

    <main>
        <div class="reservas">
            <?php
            mostrarReservas();
            ?>
        </div>
        <?php if (!empty($mensaje["error"])) { ?>
            <br />
            <div class="error"><?= $mensaje["error"] ?></div>
        <?php } elseif (!empty($mensaje["valido"])) { ?>
            <br />
            <div class="valido"><?= $mensaje["valido"] ?></div>
        <?php } ?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>