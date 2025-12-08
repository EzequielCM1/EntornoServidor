<!-- 
    Página de gestión de equipo de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
-->
<?php
// iniciamos sesion
session_start();
//recogemos los  datos de datos.php
require_once './datos.php';

if (!isset($_SESSION['jugador'])) {
    header("Location: index.php");
    exit();
}
//mostrar mensaje
$mensaje = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);
//total del equipo
$costeTotal = $_SESSION['costeTotal'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['accion'])) {

    $accion = htmlspecialchars(trim($_POST['accion'] ?? ''));

    if ($accion == "reclutar") {
        $idHeore = htmlspecialchars($_POST['id_heroe'] ?? '');

        //validar que no este vacia
        if (empty($idHeore)) {
            $_SESSION['flash_message'] = "Hubo un problema al reclutar el heroe ";
            header("Location: equipo.php");
            exit();
        }

        // validar que existe
        if (!isset(HEROES[$idHeore])) {
            $_SESSION['flash_message'] = "El héroe no existe.";
            header("Location: equipo.php");
            exit();
        }

        // Validar duplicado
        if (in_array($idHeore, $_SESSION['equipo'], true)) {
            $_SESSION['flash_message'] = "El heroe ya está reclutado ";
            header("Location: equipo.php");
            exit();
        }

        // Guardamos SOLO el ID
        $_SESSION['equipo'][] = $idHeore;
        $_SESSION['costeTotal'] += HEROES[$idHeore]['coste'];
        $_SESSION['presupuesto'] -= HEROES[$idHeore]['coste'];
        $_SESSION['flash_message'] = "El heroe se ha guardado correctamente ";

        header("Location: equipo.php");
        exit();
    }

    if ($accion == "eliminar") {
        $idHeore = htmlspecialchars($_POST['id_heroe'] ?? '');

        //validar que no este vacia
        if (empty($idHeore)) {
            $_SESSION['flash_message'] = "Hubo un problema al eliminar el heroe ";
            header("Location: equipo.php");
            exit();
        }

        // validar que existe
        if (!isset(HEROES[$idHeore])) {
            $_SESSION['flash_message'] = "El héroe no existe.";
            header("Location: equipo.php");
            exit();
        }

        // COMPROBAR que realmente está en el equipo
        if (!in_array($idHeore, $_SESSION['equipo'], true)) {
            $_SESSION['flash_message'] = "El heroe no se encuentra en el equipo ";
            header("Location: equipo.php");
            exit();
        }

        // Eliminar de sesión
        $clave = array_search($idHeore, $_SESSION['equipo']);
        unset($_SESSION['equipo'][$clave]);

        $_SESSION['costeTotal'] -= HEROES[$idHeore]['coste'];
        $_SESSION['presupuesto'] += HEROES[$idHeore]['coste'];
        $_SESSION['flash_message'] = "El héroe se ha eliminado correctamente ";

        header("Location: equipo.php");
        exit();
    }
}

$equipo_contador = count($_SESSION['equipo']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipo de Héroes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-800">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Cabecera con datos del jugador y acciones -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Panel del Jugador: <span class="text-indigo-600"><?= $_SESSION['jugador'] ?></span></h1>
                <p class="text-slate-500">Forma tu equipo gestionando tu presupuesto.</p>
            </div>
            <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                <!-- Paneles de información rápida -->
                <div class="text-center bg-white shadow-md rounded-lg p-3 min-w-[160px]">
                    <span class="text-sm font-semibold text-slate-500">Presupuesto Restante</span>
                    <p class="text-2xl font-bold text-green-600"><?= $_SESSION['presupuesto'] ?> Puntos</p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Héroes</span>
                    <p class="text-2xl font-bold text-back-600"><?= $equipo_contador ?></p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Coste Total</span>
                    <p class="text-2xl font-bold text-indigo-600"><?= $costeTotal ?> Puntos</p>
                </div>
                <!-- Acciones principales -->
                <div class="flex flex-col gap-2">
                    <a href="analisis.php" class="text-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">Ver Análisis</a>
                    <a href="reiniciar.php" name="reiniciar" class="text-center py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700">Reiniciar</a>
                </div>

            </div>
        </header>

        <!-- Sección de héroes reclutados y disponibles -->
        <section>
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Lista de Héroes</h2>
            <!-- distintos tipos de mensaje en función si es de éxito o error -->
            <!-- <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert"> -->
            <?php if (!empty($mensaje)): ?>
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md" role="alert">
                    <p><?= $mensaje ?></p>
                </div>
            <?php endif; ?>

            <!-- Grid de héroes -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                <!-- Tarjeta de héroe (ejemplo1 - héroe sin incluir en la lista) -->

                <?php foreach (HEROES as $id => $heroe): ?>

                    <div class='rounded-lg shadow-xl overflow-hidden relative h-[420px] group'>
                        <!-- ring-4 ring-offset-2 ring-indigo-500 -->
                        <img class='w-full h-full object-cover' src='img/<?= $heroe['imagen'] ?>' alt='Nombre del héroe'>
                        <div class='absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out'>
                            <div class='p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300'>
                                <div>
                                    <h3 class='text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1'><?= $heroe['nombre'] ?></h3>
                                    <p class='text-base font-medium text-indigo-200 mb-2'><?= $heroe['clase'] ?></p>
                                </div>
                                <div class='text-xs space-y-1 mb-3'>
                                    <p><strong>Ataque: </strong><?= $heroe['ataque'] ?></p>
                                    <p><strong>Defensa: </strong><?= $heroe['defensa'] ?></p>
                                    <p><strong>Magia: </strong><?= $heroe['magia'] ?></p>
                                </div>
                                <p class='text-center font-bold text-indigo-300 text-lg mb-2'>Coste: <?= $heroe['coste'] ?></p>
                                <?php if ($heroe['coste'] > $_SESSION['presupuesto']) { ?>
                                    <form> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                        <input type='hidden' name='id_heroe' value='ID01'>
                                        <button type="submit" name="accion" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-gray-500 cursor-not-allowed" disabled="" value="reclutar">Reclutar</button>
                                    </form>
                                <?php } else if (!in_array($id, $_SESSION['equipo'])) { ?>
                                    <form action="" method="post"> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                        <input type='hidden' name='id_heroe' value='<?= $id ?>'>
                                        <button type="submit" name="accion" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-indigo-600 hover:bg-indigo-700" value="reclutar">Reclutar</button>
                                    </form>
                                <?php } else if (in_array($id, $_SESSION['equipo'])) {  ?>
                                    <form action="" method="post"> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                        <input type='hidden' name='id_heroe' value='<?= $id ?>'>
                                        <button type="submit" name="accion" class="w-full py-1 px-3 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150" value="eliminar">Eliminar</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>




                <div class='rounded-lg shadow-xl overflow-hidden relative h-[420px] group'>
                    <!-- ring-4 ring-offset-2 ring-indigo-500 -->
                    <img class='w-full h-full object-cover' src='img/shadow.png' alt='Nombre del héroe'>
                    <div class='absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out'>
                        <div class='p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300'>
                            <div>
                                <h3 class='text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1'>Nombre del Héroe</h3>
                                <p class='text-base font-medium text-indigo-200 mb-2'>Clase</p>
                            </div>
                            <div class='text-xs space-y-1 mb-3'>
                                <p><strong>Ataque: </strong>22</p>
                                <p><strong>Defensa: </strong>21</p>
                                <p><strong>Magia: </strong>33</p>
                            </div>
                            <p class='text-center font-bold text-indigo-300 text-lg mb-2'>Coste: 300</p>
                            <form> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                <input type='hidden' name='id_heroe' value='ID01'>
                                <button type="submit" name="accion" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-indigo-600 hover:bg-indigo-700" value="reclutar">Reclutar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta de héroe (ejemplo, héroe reclutado, se cambia el botón y borde de la card) -->
                <div class='rounded-lg shadow-xl overflow-hidden relative h-[420px] group ring-4 ring-offset-2 ring-indigo-500'>
                    <!--  -->
                    <img class='w-full h-full object-cover' src='img/shadow.png' alt='Nombre del héroe'>
                    <div class='absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out'>
                        <div class='p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300'>
                            <div>
                                <h3 class='text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1'>Nombre del Héroe</h3>
                                <p class='text-base font-medium text-indigo-200 mb-2'>Clase</p>
                            </div>
                            <div class='text-xs space-y-1 mb-3'>
                                <p><strong>Ataque: </strong>41</p>
                                <p><strong>Defensa: </strong>12</p>
                                <p><strong>Magia: </strong>54</p>
                            </div>
                            <p class='text-center font-bold text-indigo-300 text-lg mb-2'>Coste: 500</p>
                            <form> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                <input type='hidden' name='id_heroe' value='ID01'>
                                <button type="submit" name="accion" class="w-full py-1 px-3 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150" value="eliminar">Eliminar</button>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta de héroe (ejemplo, sin reclutar y sin presupuesto -> deshabilitado) -->
                <div class='rounded-lg shadow-xl overflow-hidden relative h-[420px] group'>
                    <!-- ring-4 ring-offset-2 ring-indigo-500 -->
                    <img class='w-full h-full object-cover' src='img/shadow.png' alt='Nombre del héroe'>
                    <div class='absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out'>
                        <div class='p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300'>
                            <div>
                                <h3 class='text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1'>Nombre del Héroe</h3>
                                <p class='text-base font-medium text-indigo-200 mb-2'>Clase</p>
                            </div>
                            <div class='text-xs space-y-1 mb-3'>
                                <p><strong>Ataque: </strong>56</p>
                                <p><strong>Defensa: </strong>22</p>
                                <p><strong>Magia: </strong>42</p>
                            </div>
                            <p class='text-center font-bold text-indigo-300 text-lg mb-2'>Coste: 600</p>
                            <form> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                <input type='hidden' name='id_heroe' value='ID01'>
                                <button type="submit" name="accion" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-gray-500 cursor-not-allowed" disabled="" value="reclutar">Reclutar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- Pie de página con autor y curso -->
    <footer class="text-center text-sm text-gray-500 mt-10">
        © 2025 P.Lluyot · Examen de DWES
    </footer>
</body>

</html>